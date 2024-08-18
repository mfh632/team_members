<div class="wrap">
    <h1><?= __('Team Members Settings') ?></h1>
    <hr>
    <form method="post" action="options.php">
        <?php  settings_fields('tmembers_group_team_member_setting');  ?>
        <?php //settings_fields('tmembers_group_team_member_post_type_setting');  ?>
        <?php  do_settings_sections('team_members_setting');  ?>
        <?php submit_button(); ?>
    </form>
</div>