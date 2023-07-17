// Router
import { Link } from 'react-router-dom'

// Icons
import Button from '@mui/joy/Button'
import Box from '@mui/joy/Box'

export default function NewTodo () {

    return (
        <Box
            className={`add-sapphire-todo-container`}
            sx={{
                display: 'flex',
                justifyContent: 'center',
                alignItems: 'center',
                background: '#fff'
            }}
        >

            <Link
                className={`add-todo-back-btn`}
                to="/todos"
                style={{
                    textDecoration: 'none',

                }}
            >
                <Button
                    className={`add-todo-back-btn`}
                    color="primary"
                    variant="solid"
                    underline="none"
                    sx={{
                        borderRadius: 0
                    }}
                >
                    Back
                </Button>
            </Link>
            <div className="loading">
                Loading...
            </div>
            <iframe src={`${window.location.origin}/wp-admin/post-new.php?post_type=sapphire_sm_todo`}/>
        </Box>
    )

}