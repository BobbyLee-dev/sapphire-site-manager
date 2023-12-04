// WordPress
import {useState} from '@wordpress/element'

// Router
import {Link} from 'react-router-dom'

// JoyUI
import Box from '@mui/joy/Box'
import Button from '@mui/joy/Button'
import Typography from '@mui/joy/Typography'

// Icons
import {PlusSquare} from 'react-feather'
import TodoTable from "./todoComponents/TodoTable";

// Local Components

export default function Todos() {
	const [open,] = useState(false)

	return (
		<>
			<div className={`todo-page`}>
				<Box
					sx={{
						display: 'flex',
						alignItems: 'center',
						justifyContent: 'space-between',
						mb: 2,
						gap: 2,
						flexWrap: 'wrap',
						// '& > *': {
						//     minWidth: 'clamp(0px, (500px - 100%) * 999, 100%)',
						//     flexGrow: 1,
						// },
					}}
				>
					<Typography level="h1" fontSize="xl4">

						To-Dos:
						{/*{data && (*/}
						{/*    <>*/}
						{/*        <span>Status - {statusOptions[statusParam] || 'Not Completed'}</span>*/}
						{/*    </>*/}
						{/*)}*/}
					</Typography>
					<Box sx={{flex: 999}}/>
					<Box
						sx={{
							display: 'flex',
							gap: 1,
							'& > *': {flexGrow: 1},
						}}
					>

						<Link
							to="/new-todo"
							style={{
								textDecoration: 'none',
								display: 'block',
								width: '100%',
							}}
						>
							<Button
								component={`div`}
								color="primary"
								variant="soft"
								underline="none"
								endDecorator={<PlusSquare className="feather"/>}
							>
								Add To-Do
							</Button>
						</Link>
					</Box>
				</Box>

				<TodoTable/>
			</div>
		</>
	)
}
