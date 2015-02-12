<?php

class InterpellerBaseController extends PhabricatorController {

	public function buildStandardPageResponse($view, array $data) {
		$page = $this->buildStandardPageView();

		$page->setBaseURI('/');
		$page->setTitle(idx($data, 'title'));

		$page->appendChild($view);

		$response = new AphrontWebpageResponse();
		return $response->setContent($page->render());
	}

	public function processRequest() {
		$viewer = $this->getRequest()->getUser();

		return $this->buildApplicationPage(
			array(
			),
			array(
				'title' => pht('Interpeller'),
			));
	}
}
