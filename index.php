<?php 

require_once ( 'instagram_basic_display_api.php' );

$accessToken = 'IGQVJYRnNDQVFCZAV9paUpteEQwWHJDQmRWbVpYRzdKWkhZASUpwNjFMR3UtdFV1dWhQR19mV2kwa0ZASdmxqcEJaWlBWTGJVQ0ltbXhpZA0tUZAjRiNmw5ZAGdJT3YwNUlxVkFtdzZAkVG5R';

$params = array(
	'get_code' => $_GET['code'] ?? '',
	'access_token' => $accessToken,
	'user_id' => '17841404256221068'
);

$ig = new instagram_basic_display_api ( $params );

?>

<h1>Instagram Basic Display API</h1>

<hr>

<?php if ( $ig -> hasUserAccessToken ) : ?>

	<h4>Instagram Info</h4>
	<hr>
	<?php $user = $ig -> getUser ( ); ?>

	<pre>
		<?php print_r ( $user ); ?>
	</pre>

	<h1>Username: <?= $user['username']; ?></h1>
	<h2>Instagram ID: <?= $user['id']; ?></h2>
	<h3>Media Count: <?= $user['media_count']; ?></h3>
	<h4>Account Type: <?= $user['account_type']; ?></h4>

	<!--
	<h6>Token de Acesso</h6>
	<?= $ig -> getUserAccessToken ( ); ?>

	<h6>Expira em</h6>
	<?= ceil ( $ig -> getUserAccessTokenExpires ( ) / 86400 ); ?> dias
	-->

	<hr>

	<h3>Highlighted Post</h3>
	<?php $highlightedPostId = '17912064586359738'; ?>
	<div>Media ID: <?= $highlightedPostId; ?></div>
	<div>
		<?php  
			$media = $ig -> getMedia ( $highlightedPostId );
			$mediaChildren = $ig -> getMediaChildren ( $highlightedPostId );
		?>
		<h4>Raw Data</h4>
		<textarea style="width: 100%;height: 400px;">
			Media <?php print_r ( $media ); ?>
			Children <?php print_r ( $mediaChildren ); ?>
		</textarea>
	</div>
	<div style="margin-bottom: 20px;margin-top: 20px;border: 3px solid #333;">
		<div>
			<?php if ( $mediaChildren['data'] ) : ?>
				<?php foreach ( $mediaChildren['data'] as $child ) : ?>
					
					<?php if ( 'IMAGE' == $child['media_type'] ) : ?>
						<img style="height: 320px" src="<?= $child['media_url']; ?>">
					<?php else : ?>
						<video height="240" width="320" controls>
							<source src="<?= $child['media_url']; ?>">
						</video>
					<?php endif; ?>
					
				<?php endforeach; ?>
			<?php else : ?>
				<?php if ( 'IMAGE' == $media['media_type'] ) : ?>
					<img style="height: 320px" src="<?= $media['media_url']; ?>">
				<?php else : ?>
					<video height="240" width="320" controls>
						<source src="<?= $media['media_url']; ?>">
					</video>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<div>
			<b>Caption: <?= nl2br( htmlentities( $media['caption'] ) ); ?></b>
		</div>
		<div>
			Posted by: <?= $media['username']; ?> at <?= $media['timestamp']; ?>
		</div>
		<div>
			Link: <a href="<?= $media['permalink']; ?>" target="_blank"><?= $media['permalink']; ?></a>
		</div>
		<div>
			ID: <?= $media['id']; ?>
		</div>
		<div>
			Media Type: <?= $media['media_type']; ?>
		</div>
	</div>

	<?php $usersMedia = $ig -> getUsersMedia ( ); ?>
	<h3>Users Media Page 1 (<?= count( $usersMedia['data'] ); ?>)</h3>
	<h4>Raw Data</h4>
	<textarea style="width: 100%; height: 400px;"><?php print_r( $usersMedia ); ?></textarea>
	<h4>Posts</h4>

	<ul style="list-style: none;margin: 0px;padding: 0px;">
		<?php foreach ( $usersMedia['data'] as $post ) : ?>
			<li style="margin-bottom: 20px;border: 3px solid #333;">
				<div>
					<?php if ( 'IMAGE' == $post['media_type'] || 'CAROUSEL_ALBUM' == $post['media_type'] ) : ?>
						<img style="height: 320px;" src="<?= $post['media_url']; ?>">
					<?php else : ?>
						<video height="240" width="320" controls>
							<source src="<?= $post['media_url']; ?>">
						</video>
					<?php endif; ?>
				</div>
				<div>
					<b>Caption: <?= nl2br( htmlentities( $post['caption'] ) ); ?></b>
				</div>
				<div>
					ID: <?= $post['id']; ?>
				</div>
				<div>
					Media Type: <?= $post['media_type']; ?>
				</div>
				<div>
					Media URL: <?= $post['media_url']; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php $usersMediaNext = $ig -> getPaging ( $usersMedia['paging']['next'] ); ?>
	<h3>Users Media Page 2 (<?= count( $usersMediaNext['data'] ); ?>)</h3>
	<h4>Raw Data</h4>
	<textarea style="width: 100%; height: 400px;"><?php print_r( $usersMediaNext ); ?></textarea>
	<h4>Posts</h4>

	<ul style="list-style: none;margin: 0px;padding: 0px;">
		<?php foreach ( $usersMediaNext['data'] as $post ) : ?>
			<li style="margin-bottom: 20px;border: 3px solid #333;">
				<div>
					<?php if ( 'IMAGE' == $post['media_type'] || 'CAROUSEL_ALBUM' == $post['media_type'] ) : ?>
						<img style="height: 320px;" src="<?= $post['media_url']; ?>">
					<?php else : ?>
						<video height="240" width="320" controls>
							<source src="<?= $post['media_url']; ?>">
						</video>
					<?php endif; ?>
				</div>
				<div>
					<b>Caption: <?= nl2br( htmlentities( $post['caption'] ) ); ?></b>
				</div>
				<div>
					ID: <?= $post['id']; ?>
				</div>
				<div>
					Media Type: <?= $post['media_type']; ?>
				</div>
				<div>
					Media URL: <?= $post['media_url']; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>

<?php else : ?>

	<a href="<?= $ig -> authorizationUrl; ?>">
		Autorizar w/Instagram
	</a>

<?php endif; ?>