-- Give all non-member WP users level 1 with a specific start and end date set
-- change the level (1) below and start (2017-01-01) and end (2017-12-31) dates below to per your needs.

-- title: Database Script: Apply a Membership Level to All Users Without a Level
-- layout: snippet
-- collection: membership-levels
-- category: levels, sql
-- link: https://www.paidmembershipspro.com/database-script-apply-membership-level-users-without-level/

-- You can add this recipe to your site by creating a custom plugin
-- or using the Code Snippets plugin available for free in the WordPress repository.
-- Read this companion article for step-by-step directions on either method.
-- https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/

INSERT INTO wp_pmpro_memberships_users (user_id, membership_id, status, startdate, enddate) 
SELECT 
	u.ID,  			#ID from wp_users table
	1, 			#id of the level to give users
	'active', 		#status to give users
	'2017-01-01', 		#start date in YYYY-MM-DD format
	'2017-12-31' 		#end date in YYYY-MM-DD format, use '' for auto-recurring/no end date
FROM wp_users u 
	LEFT JOIN wp_pmpro_memberships_users mu 
		ON u.ID = mu.user_id 
		AND status = 'active' 
WHERE mu.id IS NULL