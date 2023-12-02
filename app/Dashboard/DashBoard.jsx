// WordPress
// Router
import {HashRouter, Route, Routes} from 'react-router-dom'

// React Query
import {QueryClient, QueryClientProvider} from 'react-query'

// JoyUI
import {CssVarsProvider} from '@mui/joy/styles'
import GlobalStyles from '@mui/joy/GlobalStyles'
import CssBaseline from '@mui/joy/CssBaseline'
import Box from '@mui/joy/Box'

// Icons
import Typography from '@mui/joy/Typography'

// Local Components
import './dashboard.scss'
import '../assets/feather.min.js'
import Todos from './Todos/Todos'
import Sidebar from './dashboardComponents/Sidebar'
import customTheme from './dashboardComponents/theme'
import SingleTodo from "./Todos/todoComponents/SingleTodo";
import NewTodo from "./Todos/todoComponents/NewTodo";

const queryClient = new QueryClient()

export default function DashBoard() {
	return (
		<CssVarsProvider disableTransitionOnChange theme={customTheme}>
			<GlobalStyles
				styles={{
					'[data-feather], .feather': {
						color: 'var(--Icon-color)',
						margin: 'var(--Icon-margin)',
						fontSize: 'var(--Icon-fontSize, 20px)',
						width: '1em',
						height: '1em',
					},
				}}
			/>
			<CssBaseline/>
			<QueryClientProvider client={queryClient}>
				<HashRouter basename="/">
					<Box
						sx={{
							display: 'flex',
							minHeight: 'calc(100dvh - 32px)',
						}}
					>
						<Sidebar/>
						<Box
							component="main"
							className="MainContent"
							sx={(theme) => ({
								px: {
									xs: 2,
									md: 6,
								},
								pt: 1,
								pb: {
									xs: 2,
									sm: 2,
									md: 3,
								},
								my: 1,
								flex: 1,
								display: 'flex',
								flexDirection: 'column',
								minWidth: 0,
								gap: 1,
							})}
						>
							<Routes>
								<Route
									exact
									path="/"
									element={
										<Typography level="h1" fontSize="xl4">
											Sapphire Site Manager
										</Typography>
									}
								/>
								<Route
									exact
									path={'/todos'}
									element={<Todos/>}
								/>
								<Route
									exact
									path={'/todos/:todoId'}
									element={<SingleTodo/>}
								/>
								<Route
									exact
									path={'/new-todo'}
									element={<NewTodo/>}
								/>
								<Route
									exact
									path={'/theme-options'}
									element={<Todos/>}
								/>
							</Routes>
						</Box>
					</Box>
				</HashRouter>
			</QueryClientProvider>
		</CssVarsProvider>
	)
}
