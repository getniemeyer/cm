<div id="cmJobsContainer" class="cm--jobs">
	<?php if (empty($jobs)): ?>
	<p>Derzeit sind keine Jobangebote verfügbar.</p>
	<?php else: ?>
	<?php foreach ($jobs as $job): ?>
	<div class="card mb-4 position-relative">

		<a href="<?php echo esc_url(apply_filters('clevermatch_job_apply_url', $job['ApplyUrl'])); ?>" target="_blank">
			<div class="card-body">
				<h4 class="card-title"><?php echo esc_html($job['Title']); ?></h4>
				<h6 class="card-subtitle"><?php echo esc_html($job['Location']); ?></h6>
				<p class="card-text"><?php echo wp_trim_words(wp_strip_all_tags($job['Description']), 64, '...'); ?></p>
			</div>
		</a>

		<div class="card-footer d-flex <?php echo (!empty($job['AffiliateCommission'])) ? 'justify-content-between' : 'justify-content-end' ?> align-items-end">

			<!-- "Mehr Details"-Button (immer vorhanden) -->
			<a href="<?php echo esc_url(apply_filters('clevermatch_job_apply_url', $job['ApplyUrl'])); ?>" class="btn btn-info btn-sm" target="_blank">
				Mehr Details <i class="fas fa-long-arrow-right"></i>
			</a>

			<!-- Affiliate-Buttons (nur bei Commission) -->
			<?php if (!empty($job['AffiliateCommission']) && $job['AffiliateCommission'] > 0): ?>
			<?php $formattedCommission = number_format($job['AffiliateCommission'], 0, ',', '.'); ?>

			<!-- Mobile-Button -->
			<a class="affiliate-btn-mobile btn btn-warning btn-sm d-md-none" href="https://www.getniemeyer.de/projects/cleverneu/empfehlungsprogramm/" target="_blank">
				<div class="text-center">
					<span class="d-block"><?php echo $formattedCommission; ?> € &rarr;</span>
					<p class="small mb-0">für Ihre Empfehlung</p>
				</div>
			</a>

			<!-- Desktop-Button -->
			<a class="affiliate-btn-desktop btn btn-warning btn-sm position-absolute d-none d-md-flex" style="top: 1rem; right: 1rem;" href="https://www.getniemeyer.de/projects/cleverneu/empfehlungsprogramm/?utm_source=www&utm_campaign=jobad" target="_blank">
				<div class="text-center">
					<span class="d-block"><?php echo $formattedCommission; ?> € &rarr;</span>
					<p class="small mb-0">für Ihre Empfehlung</p>
				</div>
			</a>
			<?php endif; ?>
		</div>

	</div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>