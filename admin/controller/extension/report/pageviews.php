<?php

class ControllerExtensionReportPageviews extends Controller{
	/**
	 * Initialisation du rapport
	 */
	public function index(){
		$this->load->language('extension/report/pageviews');
		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extensions'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/report/pageviews', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token='  .  $this->session->data['user_token']  .  '&type=report', true);
		
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left']    = $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/report/pageviews_form', $data));
	}
	
	/**
	 * Installation du rapport
	 */
	public function install() {
		// Gestion du statut de l'extension
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('report_pageviews', ['report_pageviews_status' => 1]);

		// Appel du modèle Pageviews
		$this->load->model('extension/report/pageviews');

		// Création de la table
		$this->model_extension_report_pageviews->createTable();
	}

	/**
	 * Affichage du rapport
	 */
	public function report() {
		$this->load->language('extension/report/pageviews');
		$this->load->model('extension/report/pageviews');

		// Récupération des données dans la table
		$results['all'] = $this->model_extension_report_pageviews->getPageviews(); // Toutes les pages vues
		$results['top'] = $this->model_extension_report_pageviews->getTopPageviews(); // Les 15 pages plus visitées

		// Création d'un tableau avec les données
		$data['views'] = array(
			'all' => $results['all'],
			'top' => $results['top']
		);

		$data['user_token'] = $this->session->data['user_token'];
		
		// Affichage du rapport
		return $this->load->view('extension/report/pageviews_info', $data);
	}
	
	/**
	 * Désinstallation du rapport
	 */
	public function uninstall() {
		// Gestion du statut de l'extension
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('report_pageviews');

		// Appel du modèle Pageviews
		$this->load->model('extension/report/pageviews');
		
		// Suppression de la table
		$this->model_extension_report_pageviews->dropTable();
	}
}

?>