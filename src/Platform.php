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
    switch ($var) {
      case 'PLATFORM_ROUTES':
        $value = 'eyJodHRwOi8vYWRtaW4ubWFnZW50by1xdWh1NWJxLW96ZW1wbHVudGd6d3UuZXUucGxhdGZvcm0uc2gvIjogeyJ0byI6ICJodHRwczovL2FkbWluLm1hZ2VudG8tcXVodTVicS1vemVtcGx1bnRnend1LmV1LnBsYXRmb3JtLnNoLyIsICJ0eXBlIjogInJlZGlyZWN0IiwgIm9yaWdpbmFsX3VybCI6ICJodHRwOi8vYWRtaW4ue2RlZmF1bHR9LyJ9LCAiaHR0cHM6Ly9tYWdlbnRvLXF1aHU1YnEtb3plbXBsdW50Z3p3dS5ldS5wbGF0Zm9ybS5zaC8iOiB7InR5cGUiOiAidXBzdHJlYW0iLCAidGxzIjogeyJjbGllbnRfYXV0aGVudGljYXRpb24iOiBudWxsLCAibWluX3ZlcnNpb24iOiBudWxsLCAiY2xpZW50X2NlcnRpZmljYXRlX2F1dGhvcml0aWVzIjogW10sICJzdHJpY3RfdHJhbnNwb3J0X3NlY3VyaXR5IjogeyJwcmVsb2FkIjogbnVsbCwgImluY2x1ZGVfc3ViZG9tYWlucyI6IG51bGwsICJlbmFibGVkIjogbnVsbH19LCAiY2FjaGUiOiB7ImRlZmF1bHRfdHRsIjogMCwgImNvb2tpZXMiOiBbIioiXSwgImVuYWJsZWQiOiB0cnVlLCAiaGVhZGVycyI6IFsiQWNjZXB0IiwgIkFjY2VwdC1MYW5ndWFnZSJdfSwgInNzaSI6IHsiZW5hYmxlZCI6IGZhbHNlfSwgInVwc3RyZWFtIjogIm1hZ2VudG8iLCAib3JpZ2luYWxfdXJsIjogImh0dHBzOi8ve2RlZmF1bHR9LyIsICJyZXN0cmljdF9yb2JvdHMiOiB0cnVlfSwgImh0dHA6Ly9hbmd1bGFyLm1hZ2VudG8tcXVodTVicS1vemVtcGx1bnRnend1LmV1LnBsYXRmb3JtLnNoLyI6IHsidG8iOiAiaHR0cHM6Ly9hbmd1bGFyLm1hZ2VudG8tcXVodTVicS1vemVtcGx1bnRnend1LmV1LnBsYXRmb3JtLnNoLyIsICJ0eXBlIjogInJlZGlyZWN0IiwgIm9yaWdpbmFsX3VybCI6ICJodHRwOi8vYW5ndWxhci57ZGVmYXVsdH0vIn0sICJodHRwOi8vYXBpLm1hZ2VudG8tcXVodTVicS1vemVtcGx1bnRnend1LmV1LnBsYXRmb3JtLnNoLyI6IHsidG8iOiAiaHR0cHM6Ly9hcGkubWFnZW50by1xdWh1NWJxLW96ZW1wbHVudGd6d3UuZXUucGxhdGZvcm0uc2gvIiwgInR5cGUiOiAicmVkaXJlY3QiLCAib3JpZ2luYWxfdXJsIjogImh0dHA6Ly9hcGkue2RlZmF1bHR9LyJ9LCAiaHR0cDovL21hZ2VudG8tcXVodTVicS1vemVtcGx1bnRnend1LmV1LnBsYXRmb3JtLnNoLyI6IHsidG8iOiAiaHR0cHM6Ly9tYWdlbnRvLXF1aHU1YnEtb3plbXBsdW50Z3p3dS5ldS5wbGF0Zm9ybS5zaC8iLCAidHlwZSI6ICJyZWRpcmVjdCIsICJvcmlnaW5hbF91cmwiOiAiaHR0cDovL3tkZWZhdWx0fS8ifSwgImh0dHBzOi8vYWRtaW4ubWFnZW50by1xdWh1NWJxLW96ZW1wbHVudGd6d3UuZXUucGxhdGZvcm0uc2gvIjogeyJ0eXBlIjogInVwc3RyZWFtIiwgInRscyI6IHsiY2xpZW50X2F1dGhlbnRpY2F0aW9uIjogbnVsbCwgIm1pbl92ZXJzaW9uIjogbnVsbCwgImNsaWVudF9jZXJ0aWZpY2F0ZV9hdXRob3JpdGllcyI6IFtdLCAic3RyaWN0X3RyYW5zcG9ydF9zZWN1cml0eSI6IHsicHJlbG9hZCI6IG51bGwsICJpbmNsdWRlX3N1YmRvbWFpbnMiOiBudWxsLCAiZW5hYmxlZCI6IG51bGx9fSwgImNhY2hlIjogeyJkZWZhdWx0X3R0bCI6IDAsICJjb29raWVzIjogWyIqIl0sICJlbmFibGVkIjogdHJ1ZSwgImhlYWRlcnMiOiBbIkFjY2VwdCIsICJBY2NlcHQtTGFuZ3VhZ2UiXX0sICJzc2kiOiB7ImVuYWJsZWQiOiBmYWxzZX0sICJ1cHN0cmVhbSI6ICJsYXJhdmVsIiwgIm9yaWdpbmFsX3VybCI6ICJodHRwczovL2FkbWluLntkZWZhdWx0fS8iLCAicmVzdHJpY3Rfcm9ib3RzIjogdHJ1ZX0sICJodHRwczovL2FuZ3VsYXIubWFnZW50by1xdWh1NWJxLW96ZW1wbHVudGd6d3UuZXUucGxhdGZvcm0uc2gvIjogeyJ0eXBlIjogInVwc3RyZWFtIiwgInRscyI6IHsiY2xpZW50X2F1dGhlbnRpY2F0aW9uIjogbnVsbCwgIm1pbl92ZXJzaW9uIjogbnVsbCwgImNsaWVudF9jZXJ0aWZpY2F0ZV9hdXRob3JpdGllcyI6IFtdLCAic3RyaWN0X3RyYW5zcG9ydF9zZWN1cml0eSI6IHsicHJlbG9hZCI6IG51bGwsICJpbmNsdWRlX3N1YmRvbWFpbnMiOiBudWxsLCAiZW5hYmxlZCI6IG51bGx9fSwgImNhY2hlIjogeyJkZWZhdWx0X3R0bCI6IDAsICJjb29raWVzIjogWyIqIl0sICJlbmFibGVkIjogdHJ1ZSwgImhlYWRlcnMiOiBbIkFjY2VwdCIsICJBY2NlcHQtTGFuZ3VhZ2UiXX0sICJzc2kiOiB7ImVuYWJsZWQiOiBmYWxzZX0sICJ1cHN0cmVhbSI6ICJhbmd1bGFyIiwgIm9yaWdpbmFsX3VybCI6ICJodHRwczovL2FuZ3VsYXIue2RlZmF1bHR9LyIsICJyZXN0cmljdF9yb2JvdHMiOiB0cnVlfSwgImh0dHBzOi8vYXBpLm1hZ2VudG8tcXVodTVicS1vemVtcGx1bnRnend1LmV1LnBsYXRmb3JtLnNoLyI6IHsidHlwZSI6ICJ1cHN0cmVhbSIsICJ0bHMiOiB7ImNsaWVudF9hdXRoZW50aWNhdGlvbiI6IG51bGwsICJtaW5fdmVyc2lvbiI6IG51bGwsICJjbGllbnRfY2VydGlmaWNhdGVfYXV0aG9yaXRpZXMiOiBbXSwgInN0cmljdF90cmFuc3BvcnRfc2VjdXJpdHkiOiB7InByZWxvYWQiOiBudWxsLCAiaW5jbHVkZV9zdWJkb21haW5zIjogbnVsbCwgImVuYWJsZWQiOiBudWxsfX0sICJjYWNoZSI6IHsiZGVmYXVsdF90dGwiOiAwLCAiY29va2llcyI6IFsiKiJdLCAiZW5hYmxlZCI6IHRydWUsICJoZWFkZXJzIjogWyJBY2NlcHQiLCAiQWNjZXB0LUxhbmd1YWdlIl19LCAic3NpIjogeyJlbmFibGVkIjogZmFsc2V9LCAidXBzdHJlYW0iOiAibGFyYXZlbCIsICJvcmlnaW5hbF91cmwiOiAiaHR0cHM6Ly9hcGkue2RlZmF1bHR9LyIsICJyZXN0cmljdF9yb2JvdHMiOiB0cnVlfSwgImh0dHBzOi8vd3d3Lm1hZ2VudG8tcXVodTVicS1vemVtcGx1bnRnend1LmV1LnBsYXRmb3JtLnNoLyI6IHsidHlwZSI6ICJyZWRpcmVjdCIsICJ0bHMiOiB7ImNsaWVudF9hdXRoZW50aWNhdGlvbiI6IG51bGwsICJtaW5fdmVyc2lvbiI6IG51bGwsICJjbGllbnRfY2VydGlmaWNhdGVfYXV0aG9yaXRpZXMiOiBbXSwgInN0cmljdF90cmFuc3BvcnRfc2VjdXJpdHkiOiB7InByZWxvYWQiOiBudWxsLCAiaW5jbHVkZV9zdWJkb21haW5zIjogbnVsbCwgImVuYWJsZWQiOiBudWxsfX0sICJ0byI6ICJodHRwczovL21hZ2VudG8tcXVodTVicS1vemVtcGx1bnRnend1LmV1LnBsYXRmb3JtLnNoLyIsICJvcmlnaW5hbF91cmwiOiAiaHR0cHM6Ly93d3cue2RlZmF1bHR9LyIsICJyZXN0cmljdF9yb2JvdHMiOiB0cnVlfSwgImh0dHA6Ly93d3cubWFnZW50by1xdWh1NWJxLW96ZW1wbHVudGd6d3UuZXUucGxhdGZvcm0uc2gvIjogeyJ0byI6ICJodHRwczovL3d3dy5tYWdlbnRvLXF1aHU1YnEtb3plbXBsdW50Z3p3dS5ldS5wbGF0Zm9ybS5zaC8iLCAidHlwZSI6ICJyZWRpcmVjdCIsICJvcmlnaW5hbF91cmwiOiAiaHR0cDovL3d3dy57ZGVmYXVsdH0vIn19';
        break;
      case 'PLATFORM_RELATIONSHIPS':
        $value = 'eyJyZWRpcyI6IFt7InNlcnZpY2UiOiAibWFnZW50b19yZWRpcyIsICJpcCI6ICIyNTAuMC4xNDUuNzMiLCAiY2x1c3RlciI6ICJvemVtcGx1bnRnend1LW1hZ2VudG8tcXVodTVicSIsICJob3N0IjogInJlZGlzLmludGVybmFsIiwgInJlbCI6ICJyZWRpcyIsICJzY2hlbWUiOiAicmVkaXMiLCAicG9ydCI6IDYzNzl9XSwgImRhdGFiYXNlIjogW3sidXNlcm5hbWUiOiAidXNlciIsICJzY2hlbWUiOiAibXlzcWwiLCAic2VydmljZSI6ICJtYWdlbnRvX215c3FsIiwgImlwIjogIjI1MC4wLjE0NS4xMzEiLCAiY2x1c3RlciI6ICJvemVtcGx1bnRnend1LW1hZ2VudG8tcXVodTVicSIsICJob3N0IjogImRhdGFiYXNlLmludGVybmFsIiwgInJlbCI6ICJteXNxbCIsICJwYXRoIjogIm1haW4iLCAicXVlcnkiOiB7ImlzX21hc3RlciI6IHRydWV9LCAicGFzc3dvcmQiOiAiIiwgInBvcnQiOiAzMzA2fV19';
        break;
      case 'PLATFORM_VARIABLES':
        $value = 'eyJBRE1JTl9FTUFJTCI6ICJkZXZlbG9wZXJzQGJ1cnN0LWRpZ2l0YWwuY29tIiwgIkFETUlOX1VTRVJOQU1FIjogImJ1cnN0IiwgIkFETUlOX1BBU1NXT1JEIjogImFkbWluMTIzNDUiLCAiUkVERVBMT1kiOiAiMiIsICJDT01QT1NFUl9BVVRIIjogeyJodHRwLWJhc2ljIjogeyJyZXBvLm1hZ2VudG8uY29tIjogeyJ1c2VybmFtZSI6ICI4MTI4MWMyN2ZiMjdlOTM4MWMyYTExMmEzOWUyOTk2YSIsICJwYXNzd29yZCI6ICIzMjkwY2NjYzU3Njk3MzQ4NGIxMGQzMzViYmFmMWEyMyJ9fX19';
        break;
    }
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

    // tmp testng local
    $config = [
      'db_host' => '127.0.0.1',
      'db_name' => 'root',
      'db_user' => 'root',
      'db_password' => 'printerpro_magento',
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