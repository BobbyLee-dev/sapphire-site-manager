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

const MyPureIframe = memo(({src}) => (
    <iframe src={src}/>
));


function fetchTodoById({queryKey}) {

    // Get task ID from the query key
    const todoId = queryKey[1]

    const fetchTodo = async (todoId) => {
        let path = 'wp/v2/sapphire_sm_todo/' + todoId,
            options = {}

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
    const todoPassedData = useLocation()
    const urlParams = useParams()
    const result = useQuery(['todos', urlParams.todoId], fetchTodoById)
    const [showTodoEdit, setShowTodoEdit] = useState('--hide-todo-edit')

    if (result.status === 'error') {
        return (
            <div className="error">
                Error while fetching resources
            </div>
        )
    }

    function ShowTitle({result, passDown}) {

        if (result) {
            return (
                <>
                    <div>{result.title.rendered}</div>
                    {/*<iframe height="1000" frameBorder="0" width="1000"*/}
                    {/*        src={`${window.location.origin}/wp-admin/post.php?post=${result.id}&action=edit`}/>*/}
                </>
            )
        } else if (passDown) {
            return (<>
                    <div>{todoPassedData.state.title.rendered}</div>
                    {/*<iframe height="1000" frameBorder="0" width="1000"*/}
                    {/*        src={`${window.location.origin}/wp-admin/post.php?post=${todoPassedData.state.id}&action=edit`}/>*/}
                </>
            )
        } else {
            return (
                <div className="loading">
                    Loading...
                </div>
            )
        }

    }

    function toggleTodoEdit() {
        setShowTodoEdit('--show-todo-edit')

    }

    function hideTodoEdit() {
        setShowTodoEdit('--hide-todo-edit')

    }

    console.log(showTodoEdit)

    return (
        <>
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
                    <ShowTitle result={result.data}
                               passDown={todoPassedData.state}/>
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
                <MyPureIframe
                    src={`${window.location.origin}/wp-admin/post.php?post=${todoPassedData.state.id}&action=edit`}/>
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

            {/*<a href={`${window.location.origin}/wp-admin/post.php?post=${result.data.id}&action=edit`}>edit</a>*/}
        </>
    )
}
