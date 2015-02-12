<?php

final class KanbanApplication extends PhabricatorApplication {

	public function getName () {
		return pht( 'Kanban' );
	}

	public function canUninstall () {
		return false;
	}

	public function isUnlisted () {
		return false;
	}

	public function buildMainMenuItems (
		PhabricatorUser $user,
		PhabricatorController $controller = null) {

		$items = array();

		$items[] = id(new PHUIListItemView())
			->setName( pht( 'Kanban' ) )
			->addClass('core-menu-item')
			->setIcon('fa-tasks')
			->setAural( pht( 'Kanban' ) )
			->setOrder(200)
			->setHref( '/project/board/1' );

		return $items;
	}
}
