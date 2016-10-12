<?php

final class InterpellerGraphController extends InterpellerBaseController {

	public function buildApplicationCrumbs () {
		$crumbs = parent::buildApplicationCrumbs();

		return $crumbs;
	}

	public function processRequest() {
		$request = $this->getRequest();
		$user = $request->getUser();

		$saved_queries = new PhabricatorSavedQuery();
		$saved_queries->setParameter( 'filters', $request->getArr( 'filters' ) );

		$engine = id( new ManiphestTaskSearchEngine())
			->setViewer( $user );

		$query_key = 'open';

		if ( $engine->isBuiltinQuery( $query_key ) ) {
			$saved = $engine->buildSavedQueryFromBuiltin( $query_key );
		} else {
			$saved = id( new PhabricatorSavedQueryQuery() )
				->setViewer( $user )
				->withQueryKeys( array( $query_key ) )
				->executeOne();
			if ( ! $saved ) {
				return new Aphront404Response();
			}
		}
		$task_query = $engine->buildQueryFromSavedQuery( $saved );

		$tasks = $task_query
			->setViewer( $user )
			->execute();

		$phids = array();
		foreach ( $tasks as $task ) {
			$phids[] = $task->getOwnerPHID();
		}

		$handles = id( new PhabricatorHandleQuery() )
			->setViewer( $user )
			->withPHIDs( $phids )
			->execute();

		$graph_panel = new InterpellerGraphView();
		$graph_panel->setHeader( pht( 'Dependency Graph' ) );
		if ( array_key_exists( 'HTTP_HOST', $_SERVER ) )
			$graph_panel->setURI( $_SERVER[ 'HTTP_HOST' ] );
		else 
			$graph_panel->setURI( $request->getHost() );
		$graph_panel->setTasks( $tasks );
		$graph_panel->setHandles( $handles );
		$graph_panel->setViewer( $user );
		$graph_panel->setQueries( $saved_queries );

		$page = $this->newPage();
		$page->setTitle(pht('Interpeller'));
		$page->appendChild($graph_panel);
		return $page->produceAphrontResponse();
	}
}
