<?php
/**
 * Single template for the Team Member CPT.
 *
 * Shows the full member profile with featured image, role,
 * bio content, and navigation back to the archive.
 *
 * @package Flavor_Child_Team_Dynamic
 */

get_header(); ?>

<main id="team-single" class="site-main" role="main">

	<?php
	while ( have_posts() ) :
		the_post();

		$role = get_post_meta( get_the_ID(), 'team_member_role', true );
		?>

		<article <?php post_class( 'team-profile' ); ?>>

			<header class="team-profile__header">
				<div class="team-profile__header-inner">

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="team-profile__photo">
							<?php the_post_thumbnail( 'team-single' ); ?>
						</div>
					<?php endif; ?>

					<div class="team-profile__intro">
						<h1 class="team-profile__name"><?php the_title(); ?></h1>

						<?php if ( $role ) : ?>
							<p class="team-profile__role"><?php echo esc_html( $role ); ?></p>
						<?php endif; ?>

						<?php if ( has_excerpt() ) : ?>
							<p class="team-profile__tagline"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
					</div>

				</div>
			</header>

			<div class="team-profile__content entry-content">
				<?php the_content(); ?>
			</div>

			<footer class="team-profile__footer">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'team_member' ) ); ?>" class="team-profile__back">
					&larr; <?php esc_html_e( 'Back to Team', 'flavor-child-team' ); ?>
				</a>

				<?php
				the_post_navigation( array(
					'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous member:', 'flavor-child-team' ) . '</span> %title',
					'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next member:', 'flavor-child-team' ) . '</span> %title',
				) );
				?>
			</footer>

		</article>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
