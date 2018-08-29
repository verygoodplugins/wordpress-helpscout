<?php defined( 'ABSPATH' ) or exit; ?>

<h4><i class="icon-person"></i><a href="<?php echo esc_attr( admin_url( 'user-edit.php?user_id=' . $user->ID ) ); ?>"><?php echo $user->display_name; ?></a></h4>

<?php do_action( 'wp_helpscout_before_user_details', $user ); ?>

<ul class="c-sb-list c-sb-list--two-line">
	<li class="c-sb-list-item">
		<span class="c-sb-list-item__label">
		Registered
		<span class="c-sb-list-item__text"><?php echo date( 'm/d/Y', strtotime($user->user_registered) ); ?></span>
		</span>
	</li>
	<li class="c-sb-list-item">
		<span class="c-sb-list-item__label">
		Active CRM
		<span class="c-sb-list-item__text"><?php echo get_user_meta( $user->ID, 'active_crm', true ); ?></span>
		</span>
	</li>
</ul>

<div class="c-sb-section c-sb-section--toggle open">
	<div class="c-sb-section__title js-sb-toggle">
		<i class="icon-gear icon-sb"></i>Integrations
		<i class="caret sb-caret"></i>
	</div>
	<div class="c-sb-section__body">
		<?php $integrations = get_user_meta( $user->ID, 'active_integrations', true ); ?>

		<?php if( empty( $integrations ) ) : ?>
			<span class="c-sb-list-item__text">Unknown / None</span>
		<?php else : ?>

			<?php $integrations = explode(', ', $integrations); ?>
			<?php foreach( $integrations as $integration ) : ?>
				<span class="badge green"><?php echo ucwords( str_replace('-', ' ', $integration) ); ?></span> 
			<?php endforeach; ?>

		<?php endif; ?>
	</div>
</div>

<?php if( function_exists('wp_fusion') ) : ?>

	<div class="c-sb-section c-sb-section--toggle open">
		<div class="c-sb-section__title js-sb-toggle">
			<i class="icon-tag icon-sb"></i>Tags
			<i class="caret sb-caret"></i>
		</div>
		<div class="c-sb-section__body">
			<?php $tags = wp_fusion()->user->get_tags( $user->ID ) ?>

			<ul class="unstyled">
				<?php foreach( $tags as $tag ) : ?>
					<li><span class="badge blue"><?php echo wp_fusion()->user->get_tag_label( $tag ); ?></span></li>
				<?php endforeach; ?>
			</ul>

		</div>
	</div>

<?php endif; ?>

<?php do_action( 'wp_helpscout_after_user_details', $user ); ?>

<div class="divider"></div>
