<?php
/**
 * Plugin Name: 2State Widget
 * Plugin URI: http://2statereviews.com/wordpress/
 * Description: A widget to display user votes.
 * Version: 1.1
 * Author: Darren/James @ 2StateReviews
 * Author URI: http://2statereviews.com
 *
 */

// defining url here as it's handy to switch between dev/live.
$GLOBALS['twostate_url'] = 'http://2statereviews.com';


add_action( 'widgets_init', 'example_load_widgets' );

function example_load_widgets() {
	register_widget( 'TwoState_Widget' );
}

class TwoState_Widget extends WP_Widget {

	function TwoState_Widget() {
		
		$widget_ops = array( 'classname' => 'example', 'description' => __('A widget to display 2StateReviews user votes.', 'example') );

		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );

		
		$this->WP_Widget( 'example-widget', __('2State Widget', 'example'), $widget_ops, $control_ops );
	}

	
	function widget( $args, $instance ) {
		extract( $args );

		
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];
		$items = $instance['items'];

		
		echo $before_widget;

		
		if ( $title )
			echo $before_title . $title . $after_title;

		
		$json = file_get_contents($GLOBALS['twostate_url']."/api/latestuservotes/".$name."/".$items);
		$array = json_decode($json,TRUE);

		for ($i=0; $i<count($array['votes']); $i++) :
			$title = $array['votes'][$i]['title'];
			$poster = $array['votes'][$i]['poster'];
			$vote =  $array['votes'][$i]['vote'];
			$movieid = $array['votes'][$i]['movieid'];
		
			if ($vote == '1'):
				$vote = "SEE!";
			else:
				$vote = "DON'T SEE!";
			endif;
		
			echo 	$title . "<br>" .
				"<a href='".$GLOBALS['twostate_url']."/film/" . $movieid . "'>" .
				"<img src='" .
				$poster . "'></a>" .
				$vote . "<hr>";	
		endfor;
	
		echo "All my votes " .
 		"<a href='".$GLOBALS['twostate_url']."/user/user_lookup/" . $name . "'>here</a>.";

		
		echo $after_widget;
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );	
		$instance['items'] = strip_tags( $new_instance['items'] );

		return $instance;
	}

	
	function form( $instance ) {

		
		$defaults = array( 'title' => __('Movie Reviews', 'example'), 'name' => __('2', 'example'), 'items' => __('3','example') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Your 2StateReviews Userid:', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>

                <p>
                        <label for="<?php echo $this->get_field_id( 'items' ); ?>"><?php _e('Number of reviews to fetch:', 'example'); ?></label>
                        <input id="<?php echo $this->get_field_id( 'items' ); ?>" name="<?php echo $this->get_field_name( 'items' ); ?>" value="<?php echo $instance['items']; ?>" style="width:100%;" />
                </p>


	<?php
	}
}


?>