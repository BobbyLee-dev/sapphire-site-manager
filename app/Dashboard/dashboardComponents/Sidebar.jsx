// Router
import {Link} from 'react-router-dom'

// React Query
// JoyUI
import List from '@mui/joy/List'
import ListItem from '@mui/joy/ListItem'
import ListItemContent from '@mui/joy/ListItemContent'
import ListItemDecorator from '@mui/joy/ListItemDecorator'
import ListItemButton from '@mui/joy/ListItemButton'
import Sheet from '@mui/joy/Sheet'
import Typography from '@mui/joy/Typography'

// Icons
import {BarChart2, BookOpen, Home, MessageSquare, UserCheck} from 'react-feather'

// Local Components
import ColorSchemeToggle from './ColorSchemeToggle'

export default function Sidebar() {

	return (
		<React.Fragment>
			<Sheet
				className="SecondSidebar"
				sx={{
					position: 'relative',
					borderRight: '1px solid',
					borderColor: 'divider',
					transition: 'transform 0.4s',
					zIndex: 9999,
					height: 'calc(100dvh - 32px)',
					top: 0,
					p: 2,
					py: 3,
					flexShrink: 0,
					display: 'flex',
					flexDirection: 'column',
					gap: 2,
				}}
			>
				<Sheet
					sx={{
						display: 'flex',
						alignItems: 'center',
						justifyContent: 'space-between',
						px: 2,
						pt: 0,
						pb: 3,
						gap: 1,
						borderBottom: '1px solid',
						borderColor: 'divider',
					}}
				>
					<Typography fontWeight="xl"
								level="body1">Sapphire</Typography>
					<ColorSchemeToggle id={undefined} className="feather"/>
				</Sheet>
				<List
					sx={{
						'--ListItem-radius': '8px',
						'--ListItem-minHeight': '32px',
						'--List-gap': 1,
						pt: 0,
					}}
				>
					<ListItem>
						<Link
							to="/"
							style={{
								textDecoration: 'none',
								display: 'block',
								width: '100%',
							}}
						>
							<ListItemButton
								sx={{
									my: 0,
								}}
							>
								<ListItemDecorator>
									<Home className="feather"/>
								</ListItemDecorator>
								<ListItemContent><Typography level="title-sm" fontSize="sm">Overview</Typography></ListItemContent>
							</ListItemButton>
						</Link>
					</ListItem>
					<ListItem>
						<Link
							to="/todos"
							style={{
								textDecoration: 'none',
								display: 'block',
								width: '100%',
							}}
						>
							<ListItemButton
								sx={{
									my: 0,
								}}
							>
								<ListItemDecorator>
									<UserCheck className="feather"/>
								</ListItemDecorator>
								<ListItemContent><Typography level="title-sm" fontSize="sm">Todos</Typography></ListItemContent>
							</ListItemButton>
						</Link>
					</ListItem>
					<ListItem>
						<Link
							to="/"
							style={{
								textDecoration: 'none',
								display: 'block',
								width: '100%',
							}}
						>
							<ListItemButton
								sx={{
									my: 0,
								}}
							>
								<ListItemDecorator>
									<MessageSquare className="feather"/>
								</ListItemDecorator>
								<ListItemContent><Typography level="title-sm" fontSize="sm">Messages</Typography></ListItemContent>
							</ListItemButton>
						</Link>
					</ListItem>
					<ListItem>
						<Link
							to="/"
							style={{
								textDecoration: 'none',
								display: 'block',
								width: '100%',
							}}
						>
							<ListItemButton
								sx={{
									my: 0,
								}}
							>
								<ListItemDecorator>
									<BookOpen className="feather"/>
								</ListItemDecorator>
								<ListItemContent><Typography level="title-sm" fontSize="sm">Documentation</Typography></ListItemContent>
							</ListItemButton>
						</Link>
					</ListItem>
					<ListItem>
						<Link
							to="/theme-options"
							style={{
								textDecoration: 'none',
								display: 'block',
								width: '100%',
							}}
						>
							<ListItemButton
								sx={{
									my: 0,
								}}
							>
								<ListItemDecorator>
									<BarChart2 className="feather"/>
								</ListItemDecorator>
								<ListItemContent><Typography level="title-sm" fontSize="sm">Theme Options</Typography></ListItemContent>
							</ListItemButton>
						</Link>
					</ListItem>
				</List>

			</Sheet>
		</React.Fragment>
	)
}
