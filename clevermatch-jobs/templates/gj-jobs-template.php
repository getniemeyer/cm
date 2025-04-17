<div id="cmJobsContainer" class="cm--jobs row gy-4">
	<?php if (empty($jobs)): ?>
	<p>Derzeit sind keine Jobangebote verfügbar.</p>
	<?php else: ?>
	<?php foreach ($jobs as $job): ?>
	<div class="col-12 col-lg-4">
		<a class="card h-100" href="<?php echo esc_url(apply_filters('clevermatch_job_apply_url', $job['ApplyUrl'])); ?>" target="_blank">
			<div class="card-body">
				<h4 class="card-title"><?php echo esc_html($job['Title']); ?></h4>
				<h6 class="card-subtitle"><?php echo esc_html($job['Location']); ?></h6>
				<p class="card-text"><?php echo esc_html($job['Industries']); ?><br>
				<?php echo esc_html($job['JobType']); ?><br>
				<?php echo esc_html($job['ContractType']); ?></p>
			</div>
			<div class="card-footer">
				<span class="btn btn-info btn-sm">Zum Stellenprofil <i class="fas fa-long-arrow-right"></i></span>
			</div>
		</a>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>