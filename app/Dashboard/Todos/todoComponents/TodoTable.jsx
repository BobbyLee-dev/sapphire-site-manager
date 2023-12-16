// WordPress
import {useState} from '@wordpress/element'

// Router
import {Link, useSearchParams} from 'react-router-dom'

// Fuse.js fuzzy search
import Fuse from "fuse.js";

// JoyUI
import Box from '@mui/joy/Box'
import FormControl from '@mui/joy/FormControl'
import FormLabel from '@mui/joy/FormLabel'
import Input from '@mui/joy/Input'
import Select from '@mui/joy/Select'
import Option from '@mui/joy/Option'
import Table from '@mui/joy/Table'
import Sheet from '@mui/joy/Sheet'
import Typography from '@mui/joy/Typography'
import Chip from '@mui/joy/Chip'

// Icons
import {Activity, BarChart2, Check, Clock, Coffee, Feather, HelpCircle, Search, Shield, Truck} from 'react-feather'

// Local Components
import getItems from "../../dashboardComponents/getItems";

export default function TodoTable() {
	let [searchParams, setSearchParams] = useSearchParams()
	let statusParam = searchParams.get('status')
	let todoSearchParam = searchParams.get('search')
	let priorityParam = searchParams.get('priority')
	const [open,] = useState(false)
	const statusOptions = {}
	const priorityOptions = {}
	const [todoStatus, setTodoStatus] = useState(statusParam || 'not-completed')
	const [todoPriority, setTodoPriority] = useState(priorityParam || 'all')
	let todos = []


	const query = {
		// page: page,
		// per_page: 100,
	}
	const data = getItems('sapphire-site-manager/v1/todos', query, 'todos');

	// Filters
	if (data) {

		todos = data.all_todos

		// Default show not completed
		if (statusParam === null || statusParam === 'not-completed') {
			todos = todos.filter(todo => todo.status !== 'completed')
		}

		// Filter by Status
		if (statusParam !== null && statusParam !== 'not-completed' && statusParam !== 'all') {
			todos = todos.filter(todo => {
				return todo.status === statusParam
			})
		}

		// Filter by Priority
		if (priorityParam !== null && priorityParam !== 'all') {
			todos = todos.filter(todo => {
				return todo.priority === priorityParam
			})
		}

		// Filter by Search
		if (todoSearchParam !== null) {
			const searchOptions = {
				findAllMatches: true,
				keys: ['post_content', 'post_title'],
				threshold: 0.3,
			}
			const fuse = new Fuse(todos, searchOptions)
			if (todos.length) {
				todos = fuse.search(todoSearchParam)
			}
		}

		// Build Status options
		statusOptions['not-started'] = 'Not Started'
		data.statuses.forEach(statusItem => {
			statusOptions[statusItem.slug] = statusItem.name
		})
		statusOptions['not-completed'] = 'Not Completed'
		statusOptions['all'] = 'All'

		// Build priority options
		priorityOptions['all'] = 'All'
		data.priorities.forEach(priorityItem => {
			priorityOptions[priorityItem.slug] = priorityItem.name
		})

	}

	function updateTodoSearchParam(e) {
		if (e.target.value) {
			searchParams.set('search', e.target.value)
			setSearchParams(searchParams)
		} else {
			searchParams.delete('search')
			setSearchParams(searchParams)
		}
	}

	function updateStatus(e, newValue) {
		if (newValue) {
			setTodoStatus(newValue)
			searchParams.set('status', newValue)
			setSearchParams(searchParams)
		}
	}

	function updatePriority(e, newValue) {
		if (newValue) {
			setTodoPriority(newValue)
			searchParams.set('priority', newValue)
			setSearchParams(searchParams)
		}
	}

	return (
		<>
			{data && (
				<div className={`todo-page`}>

					{/*<Sheet*/}
					{/*	className="SearchAndFilters-mobile"*/}
					{/*	sx={{*/}
					{/*		display: {*/}
					{/*			xs: 'flex',*/}
					{/*			sm: 'none',*/}
					{/*		},*/}
					{/*		my: 1,*/}
					{/*		gap: 1,*/}
					{/*	}}*/}
					{/*>*/}
					{/*	<Input*/}
					{/*		size="sm"*/}
					{/*		placeholder="Search"*/}
					{/*		startDecorator={<Search className="feather"/>}*/}
					{/*		sx={{flexGrow: 1}}*/}
					{/*	/>*/}
					{/*	<IconButton*/}
					{/*		size="sm"*/}
					{/*		variant="outlined"*/}
					{/*		color="neutral"*/}
					{/*		onClick={() => setOpen(true)}*/}
					{/*	>*/}
					{/*		<Filter className="feather"/>*/}
					{/*	</IconButton>*/}
					{/*	<Modal open={open} onClose={() => setOpen(false)}>*/}
					{/*		<ModalDialog*/}
					{/*			aria-labelledby="filter-modal"*/}
					{/*			layout="fullscreen"*/}
					{/*		>*/}
					{/*			<ModalClose/>*/}
					{/*			<Typography id="filter-modal" level="h2">*/}
					{/*				Filters*/}
					{/*			</Typography>*/}
					{/*			<Divider sx={{my: 2}}/>*/}
					{/*			<Sheet*/}
					{/*				sx={{*/}
					{/*					display: 'flex',*/}
					{/*					flexDirection: 'column',*/}
					{/*					gap: 2,*/}
					{/*				}}*/}
					{/*			>*/}
					{/*				<Button*/}
					{/*					color="primary"*/}
					{/*					onClick={() => setOpen(false)}*/}
					{/*				>*/}
					{/*					Submit*/}
					{/*				</Button>*/}
					{/*			</Sheet>*/}
					{/*		</ModalDialog>*/}
					{/*	</Modal>*/}
					{/*</Sheet>*/}
					<Box
						className="SearchAndFilters-tabletUp"
						sx={{
							borderRadius: 'sm',
							py: 2,
							display: {
								xs: 'none',
								sm: 'flex',
							},
							flexWrap: 'wrap',
							gap: 1.5,
							'& > *': {
								minWidth: {
									xs: '120px',
									md: '160px',
								},
							},
						}}
					>

						<>
							<FormControl sx={{flex: 1}} size="sm">
								<FormLabel>Search for To-do</FormLabel>
								<Input
									value={todoSearchParam}
									placeholder="Search"
									startDecorator={<Search className="feather"/>}
									onChange={(e) => updateTodoSearchParam(e)}
								/>
							</FormControl>

							<FormControl size="sm">
								<FormLabel>Status</FormLabel>
								<Select
									slotProps={{button: {sx: {whiteSpace: 'nowrap'}}}}
									defaultValue={todoStatus}
									value={statusParam || 'not-completed'}
									onChange={(e, newValue) => updateStatus(e, newValue)}
								>

									{
										Object.keys(statusOptions).map((oneKey, i) => {
											return (
												<Option key={oneKey} value={oneKey}>{statusOptions[oneKey]}</Option>
											)
										})
									}
								</Select>
							</FormControl>

							<FormControl size="sm">
								<FormLabel>Priority</FormLabel>
								<Select
									slotProps={{button: {sx: {whiteSpace: 'nowrap'}}}}
									defaultValue={todoPriority}
									value={priorityParam || 'all'}
									onChange={(e, newValue) => updatePriority(e, newValue)}
								>
									{
										Object.keys(priorityOptions).map((oneKey, i) => {
											return (
												<Option key={oneKey} value={oneKey}>{priorityOptions[oneKey]}</Option>
											)
										})
									}
								</Select>
							</FormControl>
						</>


					</Box>
					<Sheet
						className="OrderTableContainer"
						variant="outlined"
						sx={{
							width: '100%',
							borderRadius: 'sm',
							flex: 1,
							overflow: 'auto',
							minHeight: 0,
						}}
					>
						<Table
							aria-labelledby="tableTitle"
							stickyHeader
							hoverRow
							sx={{
								'--TableCell-headBackground': (theme) =>
									theme.vars.palette.background.level1,
								'--Table-headerUnderlineThickness': '1px',
								'--TableRow-hoverBackground': (theme) =>
									theme.vars.palette.background.level1,
							}}
						>
							<thead>
							<tr>
								<th
									style={{
										width: '40%',
										padding: '12px 20px',
										height: 'auto',
									}}
								>
									Title
								</th>
								<th style={{width: '15%', padding: '12px 20px'}}>
									Status
								</th>
								<th style={{width: '15%', padding: '12px 20px'}}>
									Priority
								</th>
							</tr>
							</thead>
							<tbody>
							{todos &&
								todos.map((todo) => {
									todo = todo.item ?? todo;
									return (
										<tr key={todo.ID || todo.item.ID}>
											<td style={{padding: 0}}>
												<Link
													to={`/todos/${todo.ID || todo.item.ID}`}
													// to={'/'}
													state={todo}
													style={{
														textDecoration: 'none',
														display: 'block',
														flex: '1',
														padding: '12px 20px',
													}}
												>
													<Typography
														fontWeight="md"
														level="body2"
														textColor="text.primary"
													>
														{todo.post_title || todo.item.post_title}
													</Typography>
												</Link>
											</td>
											<td style={{minWidth: '160px'}}>
												<Chip
													variant="outlined"
													size="sm"
													startDecorator={
														{
															Completed: <Check className="feather"/>,
															'In Progress': <Activity className={`feather`}/>,
															Dependency: <HelpCircle className={`feather`}/>,
															'Not Started': <Feather className={`feather`}/>
														}[todo.status_name]
													}
													color={
														{
															Completed: 'primary',
															'In Progress': 'success',
															Dependency: 'info',
															'Not Started': 'neutral'
														}[todo.status_name]
													}
												>
													{todo.status_name}
												</Chip>
											</td>
											<td>
												<Chip
													variant="solid"
													size="sm"
													startDecorator={
														{
															Low: <Truck className="feather"/>,
															Medium: <Shield className={`feather`}/>,
															High: <BarChart2 className={`feather`}/>,
															ASAP: <Clock className={`feather`}/>,
															'Not Set': <Coffee className={`feather`}/>
														}[todo.priority_name]
													}
													color={
														{
															Low: 'success',
															Medium: 'warning',
															High: 'danger',
															ASAP: 'info',
															'Not Set': 'neutral'
														}[todo.priority_name]
													}
												>
													{todo.priority_name}
												</Chip>
											</td>

										</tr>
									)
								})}
							</tbody>
						</Table>
					</Sheet>

				</div>
			)}
		</>
	)
}
