<?php
use SANGO\App;

$should_show_header = App::get('layout')->should_render_header();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta name="msapplication-TileColor" content="<?php echo sng_get_status_bar_color(); ?>">
  <meta name="theme-color" content="<?php echo sng_get_status_bar_color(); ?>">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/reset.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">

  <?php wp_head(); // 削除禁止 ?>
  <meta name="google-site-verification" content="EfJGjFwJF35T_JsW_j93OucnuWf0OP4xQMREFKaBj9Y" />
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <div id="container">
    <?php if ($should_show_header) {
      App::get('layout')->render_header();
    }
