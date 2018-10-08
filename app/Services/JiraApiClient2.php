<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 05.10.18
 * Time: 10:29
 */

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

/**
 * Class JiraApiClient
 *
 * @package App\Services
 */
class JiraApiClient2 extends Client
{
  private $client = null;

  protected $username = NULL;
  protected $password = NULL;
  protected $apiUrl = NULL;

  /**
   * JiraApiClient constructor.
   *
   * Constructor.
   *

   * @return JiraApiClient2
   */
  public function __construct() {
    $username = config('jira.auth.basic.username');
    $password = config('jira.auth.basic.password');
    $apiUrl = config('jira.host');
    //var_dump($apiUrl);die;

    $this->username = $username;
    $this->password = $password;
    $this->apiUrl = $apiUrl;

    $jiraCredentials = base64_encode($username . ':' . $password);

    parent::__construct(['base_uri' => $apiUrl . '/rest/api/3/']);
    $this->setDefaultOption('auth', [$username, $password], 'basic');
    $this->setDefaultOption('headers', array(
      'Accept' => 'application/json',
    ));


    /*$response = $this->get($this->apiUrl .'/rest/api/3/',
      [
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => 'Basic ' . $jiraCredentials
        ],
      ]);
    var_dump($response);die;*/
  }

  /**
   * Requests a specific issue
   *
   * @param string issueKey
   *   The unique issue identifier (eg JIRA-123)
   *
   * @return array
   *   The response, including results.
   */
  public function getIssue($issueKey) {
    /** @var Request $request */
    $request = $this->createRequest('GET','issue/' . $issueKey);
    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }

  /**
   * Requests an Issue object for a specific project issue type.
   *
   * @param string $projectIds
   *   A comma separated list of project Ids
   *
   * @param string $projectKeys
   *   A comma separated list of project keys
   *
   * @param array $issueTypeIds
   *   An array of issuetypeIds
   *
   * @param array $issueTypeNames
   *   An array of issuetypeNames
   *
   * @return array
   *  The response, including results
   */
  public function createMeta($projectIds=NULL, $projectKeys=NULL, $issueTypeIds=NULL, $issuetypeNames=NULL) {

    $queryString = 'projectIds=' . $projectIds . '&projectKeys=' . $projectKeys . '&issuetypeIds=' . $issueTypeIds . '&issuetypeNames=' . $issuetypeNames;
    $queryString .= '&expand=projects.issuetypes.fields';

    $request = $this->createRequest('GET','issue/createmeta?' . $queryString);
    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }
  /**
   * Gets a Project
   *
   * @param string $projectKey
   *  The project ID or Key
   *
   * @return array
   *  The response, including results
   */
  public function getProject($projectKey) {

    $request = $this->createRequest('GET','project/' . $projectKey);
    $response = $this->send($request);
    $data = $response->json();

    return $data;
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

    $fields = array(
      "jql" => $jql,
      "startAt" => $offset,
      "maxResults" => $limit,
      "fields" => array($fields),
      "expand" => array($expand),
    );
    $request = $this->createRequest('POST','search');
    $request->setBody(Stream::factory(json_encode($fields)));
    $response = $this->send($request);
    $data = $response->json();

    return $data;
  }
}
