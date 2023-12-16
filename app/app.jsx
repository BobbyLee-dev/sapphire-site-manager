// WordPress
import {render} from '@wordpress/element'
import '@fontsource/inter';


// Local Components
import './app.scss'
import DashBoard from "./Dashboard/DashBoard"

document.addEventListener('DOMContentLoaded', () => {
	const sapphireSiteManagerRootId = window.sapphireSiteManager.root_id;
	const sapphireSiteManagerDashboard = document.getElementById(sapphireSiteManagerRootId);

	// Render Dashboard
	if (
		'undefined' !==
		typeof sapphireSiteManagerDashboard &&
		null !== sapphireSiteManagerDashboard
	) {
		render(<DashBoard/>, sapphireSiteManagerDashboard)
	}

	// Render Assistant
	// TODO: Render assistant
})
