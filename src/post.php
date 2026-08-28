<?php
namespace Src;

class Post {
  private $db;
  private $requestMethod;
  private $postId;

  public function __construct($db, $requestMethod, $postId)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->postId = $postId;
  }

  public function processRequest()
  {
    switch ($this->requestMethod) {
      case 'GET':
	  
		 // get last 10 records
        if ($this->postId == 'five') {
          $response = $this->getFivePosts();
		  
		 // get specific record
		} elseif ($this->postId) {
          $response = $this->getPost($this->postId);
		  
		 // get all records
        } else {
          $response = $this->getAllPosts();
        };
		
        break;
      case 'POST':
        $response = $this->createPost();
        break;
      case 'PUT':
        $response = $this->updatePost($this->postId);
        break;
      case 'DELETE':
        $response = $this->deletePost($this->postId);
        break;
      default:
        $response = $this->notFoundResponse();
        break;
    }
    header($response['status_code_header']);
    if ($response['body']) {
        echo $response['body'];
    }
  }
  
// example get request (5 posts)
// endpoint http://localhost/d3/api/five
  private function getFivePosts()
  {
    $query = "SELECT * FROM data ORDER BY id desc LIMIT 5;";

    try {
      $statement = $this->db->query($query);
      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }  
  
  
// example get request (all)
// endpoint http://localhost/d3/api/
  private function getAllPosts()
  {
    $query = "SELECT * FROM data;";

    try {
      $statement = $this->db->query($query);
      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }

    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }
  
// example get request
// endpoint http://localhost/d3/api/$post_id
  private function getPost($id)
  {
    $result = $this->find($id);
    if (! $result) {
        return $this->notFoundResponse();
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

// example post request
// endpoint http://localhost/d3/api/
// json {"first_name":111,"last_name":2,"city":3,"nummeric_one":4,"date":"2021-09-01","nummeric_two":5}
  private function createPost()
  {
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    if (! $this->validatePost($input)) {
      return $this->unprocessableEntityResponse();
    }

    $query = "
      INSERT INTO data
          (first_name, last_name, city, nummeric_one, date, nummeric_two)
      VALUES
          (:first_name, :last_name, :city, :nummeric_one, :date, :nummeric_two);
    ";
	
    try {
      $statement = $this->db->prepare($query);
      $statement->execute(array(	  
		  'first_name' 	=> $input['first_name'],
		  'last_name' 	=> $input['last_name'],
		  'city' 		=> $input['city'],
		  'nummeric_one' 	=> $input['nummeric_one'],
		  'date' 			=> $input['date'],
		  'nummeric_two' 	=> $input['nummeric_two'],
      ));
      $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }

    $response['status_code_header'] = 'HTTP/1.1 201 Created';
    $response['body'] = json_encode(array('message' => 'Post Created'));
    return $response;
  }

// example update request
// endpoint http://localhost/d3/api/$post_id
// json {"first_name":111,"last_name":2,"city":3,"nummeric_one":4,"date":"2021-09-01","nummeric_two":5}
  private function updatePost($id)
  {
    $result = $this->find($id);
    if (! $result) {
      return $this->notFoundResponse();
    }
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    if (! $this->validatePost($input)) {
      return $this->unprocessableEntityResponse();
    }

    $statement = "
      UPDATE data
      SET
		  first_name = :first_name,
		  last_name = :last_name, 
		  city = :city,
		  nummeric_one = :nummeric_one,
		  date = :date,
		  nummeric_two = :nummeric_two
      WHERE id = :id;
    ";

    try {
      $statement = $this->db->prepare($statement);
      $statement->execute(array(
		  'id' => (int) $id,
		  'first_name' 	=> $input['first_name'],
		  'last_name' 	=> $input['last_name'],
		  'city' 		=> $input['city'],
		  'nummeric_one' 	=> $input['nummeric_one'],
		  'date' 			=> $input['date'],
		  'nummeric_two' 	=> $input['nummeric_two'],
      ));
      $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Post Updated!'));
    return $response;
  }
  
// example delete request
// endpoint http://localhost/d3/api/$post_id
  private function deletePost($id)
  {
    $result = $this->find($id);
    if (! $result) {
      return $this->notFoundResponse();
    }

    $query = "
      DELETE FROM data
      WHERE id = :id;
    ";

    try {
      $statement = $this->db->prepare($query);
      $statement->execute(array('id' => $id));
      $statement->rowCount();
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode(array('message' => 'Post Deleted!'));
    return $response;
  }

  public function find($id)
  {
    $query = "
      SELECT
          *
      FROM
          data
      WHERE id = :id;
    ";

    try {
      $statement = $this->db->prepare($query);
      $statement->execute(array('id' => $id));
      $result = $statement->fetch(\PDO::FETCH_ASSOC);
      return $result;
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }

  private function validatePost($input)
  {

	if( !isset($input['first_name']) || !isset($input['last_name']) || !isset($input['city']) || !isset($input['nummeric_one']) || !isset($input['date']) || !isset($input['nummeric_two'])) {
		return false;
	}

    return true;
  }

  private function unprocessableEntityResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = json_encode([
      'error' => 'Invalid input'
    ]);
    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = json_encode([
      'error' => 'An error occurred!'
    ]);
    return $response;
  }
}