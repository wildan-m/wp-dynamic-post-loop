<?php
/**
 * Archive template for the Team Member CPT.
 *
 * Displays a responsive card grid with pagination.
 * Replaces the old static HTML team/portfolio listing.
 *
 * @package Flavor_Child_Team_Dynamic
 */

get_header(); ?>

<main id="team-archive" class="site-main" role="main">
	<div class="team-archive-wrap">

		<header class="team-archive-header">
			<h1 class="team-archive-title">
				<?php
				post_type_archive_title();
				?>
			</h1>
			<?php if ( get_post_type_object( 'team_member' )->description ) : ?>
				<p class="team-archive-description">
					<?php echo esc_html( get_post_type_object( 'team_member' )->description ); ?>
				</p>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>

			<div class="team-grid">

				<?php
				while ( have_posts() ) :
					the_post();

					$role = get_post_meta( get_the_ID(), 'team_member_role', true );
					?>

					<article <?php post_class( 'team-card' ); ?>>

						<a href="<?php the_permalink(); ?>" class="team-card__link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">

							<?php if ( has_post_thumbnail() ) : ?>
								<div class="team-card__image">
									<?php the_post_thumbnail( 'team-card', array( 'loading' => 'lazy' ) ); ?>
								</div>
							<?php else : ?>
								<div class="team-card__image team-card__image--placeholder">
									<span class="screen-reader-text">
										<?php esc_html_e( 'No photo available', 'flavor-child-team' ); ?>
									</span>
								</div>
							<?php endif; ?>

							<div class="team-card__body">
								<h2 class="team-card__name">
									<?php the_title(); ?>
								</h2>

								<?php if ( $role ) : ?>
									<p class="team-card__role">
										<?php echo esc_html( $role ); ?>
									</p>
								<?php endif; ?>

								<?php if ( has_excerpt() ) : ?>
									<p class="team-card__excerpt">
										<?php echo esc_html( get_the_excerpt() ); ?>
									</p>
								<?php endif; ?>
							</div>

						</a>

					</article>

				<?php endwhile; ?>

			</div><!-- .team-grid -->

			<?php
			// Pagination.
			$pagination = paginate_links( array(
				'prev_text' => sprintf(
					'<span class="screen-reader-text">%s</span>&laquo;',
					esc_html__( 'Previous page', 'flavor-child-team' )
				),
				'next_text' => sprintf(
					'<span class="screen-reader-text">%s</span>&raquo;',
					esc_html__( 'Next page', 'flavor-child-team' )
				),
				'type'      => 'list',
			) );

			if ( $pagination ) :
				?>
				<nav class="team-pagination" aria-label="<?php esc_attr_e( 'Team members pagination', 'flavor-child-team' ); ?>">
					<?php echo $pagination; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links() returns safe HTML. ?>
				</nav>
			<?php endif; ?>

		<?php else : ?>

			<section class="team-no-results">
				<h2><?php esc_html_e( 'No team members found', 'flavor-child-team' ); ?></h2>
				<p><?php esc_html_e( 'There are no team members to display right now. Check back soon!', 'flavor-child-team' ); ?></p>
			</section>

		<?php endif; ?>

	</div><!-- .team-archive-wrap -->
</main>

<?php get_footer(); ?>
