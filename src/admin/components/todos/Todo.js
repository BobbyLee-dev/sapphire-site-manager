// WordPress
import {memo, useState} from '@wordpress/element'
import apiFetch from '@wordpress/api-fetch'

// Router
import {useLocation, Link, useParams} from 'react-router-dom'

// React Query
import {useQuery} from 'react-query'

// JoyUI
import {Typography} from '@mui/joy'
import Box from "@mui/joy/Box";
import Button from "@mui/joy/Button";
import {PlusSquare} from "react-feather";
import Select from '@mui/joy/Select';
import Option from '@mui/joy/Option';

// Lodash
import {isEmpty} from "lodash";

const EditToDoIframe = memo(({src}) => (
    <iframe src={src}/>
));

function fetchTodoById({queryKey}) {
    // Get todo ID from the query key
    const todoId = queryKey[1]
    const fetchTodo = async (todoId) => {
        // let path = 'wp-json/v2/sapphire_sm_todo/' + todoId
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
        return (
            <>
                <Select defaultValue="dog">
                    <Option value="dog">Dog</Option>
                    <Option value="cat">Cat</Option>
                </Select>
                <Box
                    sx={{
                        display: 'flex',
                        alignItems: 'center',
                        my: 0,
                        gap: 1,
                        flexWrap: 'wrap',
                        '& > *': {
                            minWidth: 'clamp(0px, (500px - 100%) * 999, 100%)',
                            flexGrow: 1,
                        },
                    }}
                >
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
                </Box>

                <div className={`edit-sapphire-todo ${showTodoEdit}`}>
                    <EditToDoIframe
                        src={`${window.location.origin}/wp-admin/post.php?post=${todoData.ID}&action=edit`}/>
                    <Button
                        className={`add-todo-back-btn`}
                        color="primary"
                        variant="soft"
                        underline="none"
                        onClick={hideTodoEdit}
                    >
                        Back
                    </Button>
                </div>

            </>
        )
    }

}
