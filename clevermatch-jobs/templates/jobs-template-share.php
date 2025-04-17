<div id="cmJobsContainer" class="cm--jobs">
	<?php if (empty($jobs)): ?>
	<p>Derzeit sind keine Jobangebote verfügbar.</p>
	<?php else: ?>
	<?php 
		$i = 0;
		foreach ($jobs as $job): 
		?>
	<div class="card mb-4 position-relative">

		<!-- Card Body -->
		<a href="<?php echo esc_url(apply_filters('clevermatch_job_apply_url', $job['ApplyUrl'])); ?>" target="_blank">
			<div class="card-body">
				<h4 class="card-title"><?php echo esc_html($job['Title']); ?></h4>
				<h6 class="card-subtitle"><?php echo esc_html($job['Location']); ?></h6>
				<p class="card-text"><?php echo wp_trim_words(wp_strip_all_tags($job['Description']), 64, '...'); ?></p>
			</div>
		</a>

		<!-- Card Footer -->
		<div class="card-footer d-flex justify-content-between align-items-end">
			<!-- "Mehr Details"-Button -->
			<a href="<?php echo esc_url(apply_filters('clevermatch_job_apply_url', $job['ApplyUrl'])); ?>" class="btn btn-info btn-sm" target="_blank">Mehr Details <i class="fas fa-long-arrow-right"></i>
			</a>

			<!-- Mobile Share Button -->
			<?php if (!empty($job['AffiliateCommission']) && $job['AffiliateCommission'] > 0): ?>
			<?php $formattedCommission = number_format($job['AffiliateCommission'], 0, ',', '.'); ?>

			<button class="affiliate-p-btn-mobile btn btn-warning btn-sm d-md-none d-flex" data-bs-toggle="modal" data-bs-target="#shariffModal-<?php echo $i; ?>">
				<div class="d-flex align-items-center">
					<div class="text-center">
						<p class="small mb-0">Position empfehlen für</p>
						<i class="fas fa-share-square"></i><span class="fw-bold"><?php echo $formattedCommission; ?> €</span>
					</div>
				</div>
			</button>
			<?php endif; ?>
		</div>

		<!-- Desktop Share Button -->
		<?php if (!empty($job['AffiliateCommission']) && $job['AffiliateCommission'] > 0): ?>
		<?php $formattedCommission = number_format($job['AffiliateCommission'], 0, ',', '.'); ?>
		<button class="affiliate-p-btn-desktop btn btn-warning btn-sm position-absolute d-none d-md-flex" data-bs-toggle="modal" data-bs-target="#shariffModal-<?php echo $i; ?>">
			<div class="d-flex align-items-center">
				<i class="fas fa-share-square me-2"></i>
				<div class="text-center">
					<p class="small mb-0">Position empfehlen für</p>
					<span class="fw-bold"><?php echo $formattedCommission; ?> €</span>
				</div>
			</div>
		</button>

		<!-- Share Modal -->
		<div class="modal modal-lg modal-share fade" id="shariffModal-<?php echo $i; ?>" tabindex="-1" aria-labelledby="shariffModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<?php if (CleverMatch_Jobs::has_afpid()) : ?>
						<?php
								// URL-Verarbeitung
								$job_url = esc_url(apply_filters('clevermatch_job_apply_url', $job['ApplyUrl']));
								$job_url = str_replace('&#038;', '&', $job_url);
								
								// AFPID entfernen und AFID anhängen
								$job_url = remove_query_arg('afpid', $job_url);
								if (isset($_COOKIE['afid'])) {
										$afid = sanitize_text_field($_COOKIE['afid']);
										$job_url = add_query_arg('afid', $afid, $job_url);
								}
								$encoded_job_url = urlencode($job_url);
						?>
						<div class="shariff">
							<a href="mailto:?subject=<?php echo rawurlencode('Sehr interessante Position – ich dachte sofort an Dich'); ?>&body=<?php 
								echo rawurlencode("Ich habe gerade diese Position gefunden und dachte: Die könnte was für Dich sein. Schau doch mal:\n\n") . $encoded_job_url; ?>">
								<i class="fa fa-envelope me-2"></i> E-Mail
							</a>

							<a href="sms:<?php echo $job_url; ?>" class="shariff-sms">
								<i class="fa fa-mobile"></i> SMS
							</a>

							<a href="https://wa.me/?text=<?php echo $encoded_job_url; ?>" class="shariff-whatsapp">
								<i class="fa fa-whatsapp"></i> WhatsApp
							</a>

							<a href="https://t.me/share/url?url=<?php echo $job_url; ?>" class="shariff-telegram">
								<i class="fa fa-telegram"></i> Telegram
							</a>

							<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $encoded_job_url; ?>" class="shariff-linkedin">
								<i class="fa fa-linkedin"></i> LinkedIn
							</a>

							<a href="https://www.xing.com/app/user?op=share;url=<?php echo $job_url; ?>" class="shariff-xing">
								<i class="fa fa-xing"></i> Xing
							</a>

							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $job_url; ?>" class="shariff-facebook">
								<i class="fa fa-facebook"></i> Facebook
							</a>

							<a href="https://twitter.com/intent/tweet?url=<?php echo $job_url; ?>" class="shariff-twitter">
								<i class="fa fa-twitter"></i> Twitter
							</a>

						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php $i++; ?>

	</div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>