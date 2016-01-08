<?php

namespace Application\Repository;

class BlogPostRepository
{

	private $dbh;

	public function __construct(\PDO $dbh){
		$this->$dbh = $dbh;
	}

	public function find($pk){
		$query = <<<SQL
SELECT * FROM blog_post
WHERE (published_at IS NULL OR published_at <= NOW() and id = :id
SQL;

	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam('id', $pk, \PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetch(\PDO::FETCH_ASSOC);

	}

	public function getMostRecentPost($limit){
		$limit = (int) $limit;

		$query = <<<SQL
SELECT * FROM blog_post
WHERE published_at <= NOW()
ORDER BY published_at
DESC LIMIT {$limit};
SQL;

		return $this->fetchAll($query);
	}

	private function fetchAll($query){
		return $this->query($query)->fetchAll(\PDO::FETCH_ASSOC);
	}

	private function query($sql){
		return $this->dbh->query($sql);
	}

}