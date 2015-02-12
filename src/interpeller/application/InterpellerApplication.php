<?php

final class InterpellerApplication extends PhabricatorApplication {

	public function getName () {
		return pht( 'Interpeller' );
	}

	public function getShortDescription () {
		return pht( 'Task Dependencies' );
	}

	public function getRoutes () {
		return array (
			'/interpeller/' => array (
				'' => 'InterpellerGraphController',
			)
		);
	}

	public function getBaseURI () {
		return '/interpeller/';
	}

	public function getFontIcon () {
		return 'fa-compass';
	}

	public function isPinnedByDefault(PhabricatorUser $viewer) {
		return true;
	}

	public function getApplicationOrder () {
		return 0.111;
	}


}
