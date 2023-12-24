// WordPress
import {memo, useState} from '@wordpress/element'
import apiFetch from '@wordpress/api-fetch'

// Router
import {Link, useLocation, useNavigate, useParams} from 'react-router-dom'

// React Query
import {useQuery} from 'react-query'

// JoyUI
import {Divider} from '@mui/joy'
import Typography from '@mui/joy/Typography';
import Sheet from "@mui/joy/Sheet";
import Chip from "@mui/joy/Chip";
import Box from '@mui/joy/Box'
import Button from '@mui/joy/Button'
import {Activity, ArrowLeft, BarChart2, Check, Clock, Coffee, Feather, HelpCircle, PlusSquare, Shield, Truck} from 'react-feather'

// Lodash
import {isEmpty} from 'lodash'


const EditToDoIframe = memo(({src}) => (
	<iframe src={src}/>
))

function fetchTodoById({queryKey}) {
	// Get todo ID from the query key
	const todoId = queryKey[1]
	const fetchTodo = async (todoId) => {
		// let path = 'wp-json/v2/sapphire-sm-todo/' + todoId
		let path = 'sapphire-site-manager/v1/todo/' + todoId
		let options = {}

		try {
			options = await apiFetch({
				path: path,
				method: 'GET',
			})
		} catch (error) {
			console.log('fetchSettings Errors:', error)
		}

		return options
	}
	return fetchTodo(todoId)
}

export default function SingleTodo(props) {
	let todoData = {}
	const navigate = useNavigate()
	const passedDownData = useLocation()
	const urlParams = useParams()
	const todoQueryResult = useQuery(['todos', urlParams.todoId], fetchTodoById)
	const [showTodoEdit, setShowTodoEdit] = useState('--hide-todo-edit')

	if (passedDownData.state) {
		todoData = passedDownData.state
	}

	if (todoQueryResult.status === 'success') {
		todoData = todoQueryResult.data
	}

	console.log(todoData)

	if (todoQueryResult.status === 'error' && isEmpty(todoData)) {
		return (
			<div className="error">
				Error while fetching resources
			</div>
		)
	}

	function toggleTodoEdit() {
		setShowTodoEdit('--show-todo-edit')

	}

	function hideTodoEdit() {
		setShowTodoEdit('--hide-todo-edit')

	}

	if (isEmpty(todoData)) {
		return (
			<div className="loading">
				Loading...
			</div>
		)
	} else {
		console.log(todoData)
		return (
			<div className={`single-todo`}>
				<Box
					sx={{
						display: 'flex',
						alignItems: 'center',
						justifyContent: 'space-between',
						mb: 3,
						gap: 2,
						flexWrap: 'wrap',
					}}
				>
					{passedDownData.state ? (
							<Button startDecorator={<ArrowLeft/>} onClick={() => navigate(-1)}>Back</Button>
						) :
						<Link
							to="/todos"
							style={{
								textDecoration: 'none',
								color: '#fff'
							}}
						>
							<Button startDecorator={<ArrowLeft/>}>

								Todos
							</Button>
						</Link>

					}


					<Button
						color="primary"
						variant="soft"
						underline="none"
						endDecorator={<PlusSquare className="feather"/>}
						onClick={toggleTodoEdit}
					>
						Edit To-Do
					</Button>
				</Box>
				<Box>
					<Box sx={{flex: 999}}/>
					<Box
						sx={{
							display: 'flex',
							gap: 1,
							'& > *': {flexGrow: 1},
						}}
					>
					</Box>
				</Box>

				<Sheet
					variant="outlined"
					sx={{
						borderRadius: 'sm',
						p: 2,
						mb: 3,
					}}
				>
					<Box
						sx={{
							display: 'flex',
							alignItems: 'flex-start',
							justifyContent: 'space-between',
							flexWrap: 'wrap',
							gap: 2,
						}}
					>

						<Box>
							<Typography fontWeight="xl" level="body1" mb={1}>
								Created by:
							</Typography>
							<Chip size="sm" variant="soft" color="primary">
								Alex Jonnold lol
							</Chip>
						</Box>

						<Box>
							<Typography fontWeight="xl" level="body1" mb={1}>
								Created On: 11/03/23
							</Typography>
							<Chip size="sm" variant="soft" color="primary">
								Last Update: 11/05/23
							</Chip>
						</Box>

						<Box>
							<Typography fontWeight="xl" level="body1" mb={1}>
								Status:
							</Typography>
							<Chip
								variant="outlined"
								size="sm"
								startDecorator={
									{
										Completed: <Check className="feather"/>,
										'In Progress': <Activity className={`feather`}/>,
										Dependency: <HelpCircle className={`feather`}/>,
										'Not Started': <Feather className={`feather`}/>
									}[todoData.status_name]
								}
								color={
									{
										Completed: 'primary',
										'In Progress': 'success',
										Dependency: 'info',
										'Not Started': 'neutral'
									}[todoData.status_name]
								}
							>
								{todoData.status_name}
							</Chip>
						</Box>

						<Box>
							<Typography fontWeight="xl" level="body1" mb={1}>
								Priority
							</Typography>
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
									}[todoData.priority_name]
								}
								color={
									{
										Low: 'success',
										Medium: 'warning',
										High: 'danger',
										ASAP: 'info',
										'Not Set': 'neutral'
									}[todoData.priority_name]
								}
							>
								{todoData.priority_name}
							</Chip>
						</Box>

						<Box>
							<Typography fontWeight="xl" level="body1" mb={1}>
								Assigned To:
							</Typography>
							<Typography level="title-sm" textColor="text.primary" mb={0.5}>
								Alex Jonnold
							</Typography>
						</Box>


					</Box>
					<Divider sx={{mt: 2}}/>
					<Box
						sx={{py: 2, display: 'flex', flexDirection: 'column', alignItems: 'start'}}
					>
						<Typography level="h1" fontSize="xl4">
							<div>{todoData.post_title}</div>
						</Typography>
					</Box>
					<Divider/>
					<Box dangerouslySetInnerHTML={{
						__html: todoData.post_content
					}}/>

				</Sheet>
				<Box className={`edit-sapphire-todo ${showTodoEdit}`}>
					<Box>
						<Typography>Loading...</Typography>
					</Box>
					<EditToDoIframe
						src={`${window.location.origin}/wp-admin/post.php?post=${todoData.ID}&action=edit`}/>
					<Button
						className={`add-todo-back-btn`}
						color="primary"
						variant="solid"
						underline="none"
						onClick={hideTodoEdit}
						sx={{
							borderRadius: 0
						}}
					>
						Back
					</Button>
				</Box>

			</div>
		)
	}

}
