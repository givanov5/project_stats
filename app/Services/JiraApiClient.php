<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 08.10.18
 * Time: 15:42
 */

namespace App\Services;
use Unirest\Request;

class JiraApiClient {

  protected $username = NULL;
  protected $password = NULL;
  protected $apiUrl = NULL;
  protected $headers = [];

  public function __construct() {

    $username = config('jira.auth.basic.username');
    $password = config('jira.auth.basic.password');
    $apiUrl = config('jira.host');
    //var_dump($apiUrl);die;

    $this->username = $username;
    $this->password = $password;
    $this->apiUrl = $apiUrl . '/rest/api/3/';

    $jiraCredentialsEncoded = base64_encode($username . ':' . $password);

    $this->headers = [
      'Accept' => 'application/json',
      'Authorization' => 'Basic '. $jiraCredentialsEncoded
    ];
  }

  public function getIssue($issueKey) {
    $response = Request::get(
      $this->apiUrl . '/issue/' . $issueKey,
      $this->headers
    );

    return $response;
  }

  public function getProjects() {
    $response = Request::get(
      $this->apiUrl . '/project',
      $this->headers
    );

    $result = json_decode(json_encode($response),true);

    return $result;
  }

  public function getProject($projectKey) {
    $response = Request::get(
      $this->apiUrl . '/project/' . $projectKey,
      $this->headers
    );

    $result = json_decode(json_encode($response),true);

    return $result;
  }

  /**
   * Creates an Issue
   *
   * @param string $jql
   *  The Jira query
   *
   * @param number $offset
   *  The index of the first issue to return
   *
   * @param number $limit
   *  The maximum number of issues to return (default to 50)
   *
   * @param boolean $validateQuery
   *  whether to validate the JQL query (default to true)
   *
   * @param string $fields
   *  The list of fields to return for each issue.
   *
   * @param string $expand
   *  A comma-separated list of the parameters to expand.
   *
   * @return array
   *  The response, including results
   */
  public function search($jql, $offset=0, $limit=50, $validateQuery=true, $fields="", $expand="") {

    $fields = [
      "jql" => $jql,
      /*"startAt" => $offset,
      "maxResults" => $limit,
      "fields" => [$fields],
      "expand" => [$expand],*/
    ];

    $response = Request::get(
      $this->apiUrl . '/search',
      $this->headers,
      $fields
    );

    $result = json_decode(json_encode($response),true);

    return $result;
  }
}
