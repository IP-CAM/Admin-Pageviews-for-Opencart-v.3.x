<?php

class ModelExtensionReportPageviews extends Model {
	/**
	 * Création de la table
	 */	
	public function createTable() {
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "visited(visited_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, url VARCHAR(105), title VARCHAR(35), date DATETIME, ip_address VARCHAR(15), user_id INT);");
	}

	/**
	 * Récupération de toutes les pages vues
	 */
	public function getPageviews() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "visited");

		return $query->rows;
	}

	/**
	 * Récupération des 15 pages les plus visitées
	 */
	public function getTopPageviews() {
		$query = $this->db->query("SELECT title, url, COUNT(*) AS count FROM " . DB_PREFIX . "visited GROUP BY title, url ORDER BY count DESC LIMIT 15");

		return $query->rows;
	}
	
	/**
	 * Suppression de la table
	 */
	public function dropTable() {
		$this->db->query("DROP TABLE " . DB_PREFIX . "visited");
	}	
}

?>