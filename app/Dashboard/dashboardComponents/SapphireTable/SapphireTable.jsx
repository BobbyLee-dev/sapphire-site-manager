// WordPress
import {useState} from '@wordpress/element'

// Router
import {Link, useNavigate, useSearchParams} from 'react-router-dom'

// TanStack React Query
import {useQuery, useQueryClient} from 'react-query'

// Fuse.js fuzzy search
import Fuse from "fuse.js";

// JoyUI
import Box from '@mui/joy/Box'
import FormControl from '@mui/joy/FormControl'
import FormLabel from '@mui/joy/FormLabel'
import Select from '@mui/joy/Select'
import Option from '@mui/joy/Option'
import Table from '@mui/joy/Table'
import Sheet from '@mui/joy/Sheet'

// Icons
import getTableItems from "./getTableItems";
import Chip from "@mui/joy/Chip";
import Typography from "@mui/joy/Typography";

export default function SapphireTable(props) {
	const parentRef = React.useRef()
	let [searchParams, setSearchParams] = useSearchParams()
	let statusParam = searchParams.get('status')
	let todoSearchParam = searchParams.get('search')
	let priorityParam = searchParams.get('priority')
	const [open,] = useState(false)
	const queryClient = useQueryClient()
	const navigate = useNavigate()
	let itemsCount = 0
	const statusOptions = {}
	const priorityOptions = {}
	const [todoStatus, setTodoStatus] = useState(statusParam || 'not-completed')
	const [todoStatusName, setTodoStatusName] = useState('Not Completed')
	const [todoPriority, setTodoPriority] = useState(priorityParam || 'all')
	const [todoPriorityName, setTodoPriorityName] = useState('All')
	const [todoSearch, setTodoSearch] = useState('')
	let allItems = []
	const [searchValue, setSearchValue] = useState('')
	const searchOptions = {
		findAllMatches: true,
		keys: ['post_content', 'post_title'],
		threshold: 0.3,
	}
	const {status, data, error, isFetching, isPreviousData} = useQuery({
		queryKey: [props.queryKey],
		queryFn: () => getTableItems(props.path, props.query),
		keepPreviousData: true,
		staleTime: 5000,
	})

	// Filters
	if (data) {

		allItems = data[props.allItems];

		// Default show not completed
		if (statusParam === null || statusParam === 'not-completed') {
			allItems = allItems.filter(item => item.status !== 'completed')
		}

		// Filter by Status
		if (statusParam !== null && statusParam !== 'not-completed') {
			allItems = allItems.filter(item => {
				if (statusParam === 'all') {
					return item
				}

				return item.status === statusParam

			})
		}

		// Filter by Priority
		if (priorityParam !== null && priorityParam !== 'all') {
			allItems = allItems.filter(item => {
				return item.priority === priorityParam
			})
		}

		// Filter by Search
		if (todoSearchParam !== null) {
			const fuse = new Fuse(allItems, searchOptions)
			if (allItems.length) {
				allItems = fuse.search(todoSearchParam)
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

		itemsCount = allItems.length
	}

	function updateTodoSearchParam(e) {
		console.log(e.target.value)
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
			// setSearchParams({ status: newValue })
		}

		if (e) {
			setTodoStatusName(e.target.innerText)
		}
	}

	function updatePriority(e, newValue) {
		if (newValue) {
			setTodoPriority(newValue)

			searchParams.set('priority', newValue)
			setSearchParams(searchParams)
			// setSearchParams({ priority: newValue })
		}

		if (e) {

			setTodoStatusName(e.target.innerText)
		}
	}

	return (
		<>
			<div className={props.className}>

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
					{data && (
						<>
							{props.formControls &&
								props.formControls.map((control) => (
									<FormControl sx={{flex: 1}} size="sm">
										<FormLabel>{control.label}</FormLabel>
										{/*{control.type === 'Input' ? <SapphireInput attributes={control.attributes}/> : ''}*/}
									</FormControl>
								))
							}


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
					)}


				</Box>
				<Sheet
					className=""
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
							{props.tableHead &&
								props.tableHead.map((item) => (
									<th
										style={{
											width: item.width || 'auto',
											padding: '12px 20px',
											height: 'auto',
										}}
									>
										{item.label}
									</th>
								))
							}
						</tr>
						</thead>
						<tbody>
						{allItems &&
							allItems.map((item) => {
								item = item.item ?? item;
								return (
									<tr key={item.ID}>
										{props.tableDataItems &&
											props.tableDataItems.map((td) => (
												<td style={{padding: 0}}>
													<Link
														to={`/${props.linkBase}/${item.ID}`}
														// to={'/'}
														state={item}
														style={{
															textDecoration: 'none',
															display: 'block',
															flex: '1',
															padding: '12px 20px',
														}}
													>
														{td.chip ?
															<Chip
																variant={td.chip.variant}
																size="sm"
																startDecorator={
																	td.chip.startDecorator[item[td.chip.value]]
																}
																color={
																	td.chip.color[item[td.chip.value]]
																}
															>

																{item[td.name]}
															</Chip>
															:
															<Typography
																fontWeight="md"
																level="body2"
																textColor="text.primary"
															>
																{item[td.name]}
															</Typography>
														}
													</Link>
												</td>
											))
										}
									</tr>
								)
							})}
						</tbody>
					</Table>
				</Sheet>
			</div>
		</>
	)
}
