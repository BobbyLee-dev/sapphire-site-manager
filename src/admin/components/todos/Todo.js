// WordPress
import apiFetch from '@wordpress/api-fetch'

// Router
import { useLocation, Link, useParams } from 'react-router-dom'

// React Query
import { useQuery } from 'react-query'

// JoyUI
import { Typography } from '@mui/joy'

function fetchTodoById ({ queryKey }) {

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

export default function Todo (props) {
    const todoPassedData = useLocation()
    console.log(todoPassedData.state)

    const urlParams = useParams()

    const result = useQuery(['todos', urlParams.todoId], fetchTodoById)

    if (result.status === 'error') {
        return (
            <div className="error">
                Error while fetching resources
            </div>
        )
    }

    function ShowTitle ({ result, passDown }) {

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

    return (
        <>
            {/* <h1>{state.title}</h1> */}
            <Typography level="h1" fontSize="xl4">
                {/*{result.data.title && result.data.title.rendered}*/}
                {}
                <ShowTitle result={result.data}
                           passDown={todoPassedData.state}/>

            </Typography>

            {/*<a href={`${window.location.origin}/wp-admin/post.php?post=${result.data.id}&action=edit`}>edit</a>*/}
            {/*<iframe height="1000" frameBorder="0" width="1000"*/}
            {/*        src={`${window.location.origin}/wp-admin/post.php?post=${todoPassedData.state.id}&action=edit`}/>*/}
        </>
    )
}
