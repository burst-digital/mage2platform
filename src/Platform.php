<?php

namespace Burst\Mage2Platform;

class Platform {

  /**
   * Return encoded platform Env var
   *
   * @param $var
   *
   * @return mixed
   */
  protected function getEncodedEnvVar($var) {
    $value = getenv($var);
    return json_decode(base64_decode($value), TRUE);
  }

  /**
   * Format Platform variables as a data array
   *
   * @return array
   */
  public function getRelationsAsConfig() {
    $relationships = $this->getRelationships();

    $config = [
      'db_host' => $relationships["database"][0]["host"],
      'db_name' => $relationships["database"][0]["path"],
      'db_user' => $relationships["database"][0]["username"],
      'db_password' => $relationships["database"][0]["password"],
    ];

    $config['admin_url'] = getenv('ADMIN_URL') ?: 'admin';

    if (isset($relationships['redis'][0]['host'])) {
      $config['redis_host'] = $relationships['redis'][0]['host'];
      $config['redis_scheme'] = $relationships['redis'][0]['scheme'];
      $config['redis_port'] = $relationships['redis'][0]['port'];
    }

    if (isset($relationships['solr'][0]['host'])) {
      $config['solr_host'] = $relationships['solr'][0]['host'];
      $config['solr_path'] = $relationships['solr'][0]['path'];
      $config['solr_port'] = $relationships['solr'][0]['port'];
      $config['solr_scheme'] = $relationships['solr'][0]['scheme'];
    }

    return $config;
  }

  /**
   * Get routes information from Platform.sh environment variable.
   *
   * @return mixed
   */
  public function getRoutes() {
    return $this->getEncodedEnvVar('PLATFORM_ROUTES');
  }

  /**
   * Get relationships information from Platform.sh environment variable.
   *
   * @return mixed
   */
  public function getRelationships() {
    return $this->getEncodedEnvVar('PLATFORM_RELATIONSHIPS');
  }

  /**
   * Get custom variables from Platform.sh environment variable.
   *
   * @return mixed
   */
  public function getVariables() {
    return $this->getEncodedEnvVar('PLATFORM_VARIABLES');
  }

  /**
   * If current deploy is about master branch
   *
   * @return boolean
   */
  public function isMasterBranch() {
    return getenv('PLATFORM_ENVIRONMENT') === 'master';
  }

}