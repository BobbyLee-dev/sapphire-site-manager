// WordPress
import {memo, useState} from '@wordpress/element'
import apiFetch from '@wordpress/api-fetch'

// Router
import {useLocation, Link, useParams, useNavigate} from 'react-router-dom'

// React Query
import {useQuery} from 'react-query'

// JoyUI
import {Typography} from '@mui/joy'
import Box from '@mui/joy/Box'
import Button from '@mui/joy/Button'
import {PlusSquare, ArrowLeftCircle, ArrowLeft, UserCheck} from 'react-feather'
import Select from '@mui/joy/Select'
import Option from '@mui/joy/Option'

// Lodash
import {isEmpty} from 'lodash'
import {addQueryArgs} from '@wordpress/url'
import ListItemButton from '@mui/joy/ListItemButton'
import ListItemDecorator from '@mui/joy/ListItemDecorator'
import ListItemContent from '@mui/joy/ListItemContent'
import Chip from '@mui/joy/Chip'

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

export default function Todo(props) {
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
						mb: 2,
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
					<Typography level="h1" fontSize="xl4">
						<div>{todoData.post_title}</div>
					</Typography>
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
				<Box>
					<style>{todoData.styles}</style>
					<style>{todoData.styles_custom}</style>
					<div dangerouslySetInnerHTML={{
						__html: todoData.post_content
					}}/>
				</Box>

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
