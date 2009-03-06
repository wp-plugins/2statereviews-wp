<?php
/*
Plugin Name: 2StateReviews-WP
Plugin URI: http://2statereviews.com/
Description: 2StateReviews Badge Plugin
Author: Darren Watt / James Lloyd
Version: 1.0
Author URI: http://2statereviews.com/
*/

function widget_my2statereviews($args) {
  extract($args);
   $options = get_option("widget_my2statereviews");
    if (!is_array($options))
        {
        $options = array(
        'title' => '2StateReviews'
        );
        }  
  echo $before_widget;
  echo $before_title;
   echo $options['title'];
   echo $after_title;
  sample2statereviews();
  echo $after_widget;
}

function sample2statereviews()
{
    $options = get_option("widget_my2statereviews");
    echo '<center><a href="http://2statereviews.com"><img src="http://2statereviews.com/blogbadge/';
    echo $options['2stateusername']; 
    echo '/single.png"></a></center>';
}

function my2statereviews_control()
{
      $options = get_option("widget_my2statereviews");
      if (!is_array( $options ))
            {
            $options = array(
            'title' => '2StateReviews',
            '2stateusername' => 'Darren'
            );
            }  
    
       if ($_POST['my2statereviews-Submit'])
            {
            $options['title'] = htmlspecialchars($_POST['my2statereviews-WidgetTitle']);
            $options['2stateusername'] = htmlspecialchars($_POST['my2statereviews-WidgetUsername']);
            update_option("widget_my2statereviews", $options);
            }
    
?>   <p>
    <label for="my2statereviews-WidgetTitle">Title: </label>
    <input type="text" id="my2statereviews-WidgetTitle" name="my2statereviews-WidgetTitle" value="<?php echo $options['title'];?>" />                                                    
    <label for="my2statereviews-WidgetUsername">2StateReviews Username: </label> 
    <input type="text" id="my2statereviews-WidgetUsername" name="my2statereviews-WidgetUsername" value="<?php echo $options['2stateusername'];?>" />
    <input type="hidden" id="my2statereviews-Submit" name="my2statereviews-Submit" value="1" /></p>
    <?php
}

function my2statereviews_init()
{
  register_sidebar_widget(__('2StateReviews'), 'widget_my2statereviews');
  register_widget_control(   '2StateReviews', 'my2statereviews_control', 200, 200 );
}

add_action("plugins_loaded", "my2statereviews_init");

?>
