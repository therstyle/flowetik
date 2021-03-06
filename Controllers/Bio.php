<?php

namespace Controllers;

class Bio {
  public function get_info() {
    $info = [
      'position' => get_field('position'),
      'accolade_title' => get_field('accolade_title'),
      'accolades' => get_field('accolades'),
      'detailed_bio' => get_field('detailed_bio')
    ];

    return $info;
  }

  public function get_clients() {
    $clients = [
      'clients' => get_field('clients'),
      'name' => get_sub_field('client_name'),
      'logo' => get_sub_field('client_logo')
    ];

    return $clients;
  }

  public function get_social() {
    $social = [
      'social' => get_field('social'),
      'type' => get_sub_field('type'),
      'url' => get_sub_field('url')
    ];

    return $social;
  }
}

?>