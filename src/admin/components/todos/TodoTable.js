// WordPress
import apiFetch from '@wordpress/api-fetch'
import { addQueryArgs } from '@wordpress/url'
import { useEffect, useState } from '@wordpress/element'

// Router
import { Link, useNavigate, useSearchParams, useParams } from 'react-router-dom'

// TanStack React Query
import { useQuery, useQueryClient } from 'react-query'

// Fuse.js fuzzy search
import Fuse from 'fuse.js'

// JoyUI
import Box from '@mui/joy/Box'
import Button from '@mui/joy/Button'
import Divider from '@mui/joy/Divider'
import FormControl from '@mui/joy/FormControl'
import FormLabel from '@mui/joy/FormLabel'
import Input from '@mui/joy/Input'
import Modal from '@mui/joy/Modal'
import ModalDialog from '@mui/joy/ModalDialog'
import ModalClose from '@mui/joy/ModalClose'
import Select from '@mui/joy/Select'
import Option from '@mui/joy/Option'
import Table from '@mui/joy/Table'
import Sheet from '@mui/joy/Sheet'
import IconButton, { iconButtonClasses } from '@mui/joy/IconButton'
import Typography from '@mui/joy/Typography'
import Chip from '@mui/joy/Chip'

// Icons
import {
    ArrowLeft,
    ArrowRight,
    Filter, PlusSquare,
    Search,
} from 'react-feather'

function fetchTodos () {

    let path = 'sapphire-site-manager/v1/todos'
    const query = {
        // page: page,
        // per_page: 100,
    }

    return apiFetch({
        path: addQueryArgs(path, query),
        method: 'GET',
        parse: false,
    }).then((response) => {
        return response.json().then((data) => {
            return data
        })
    })

}

export default function TodoTable () {
    const parentRef = React.useRef()
    let [searchParams, setSearchParams] = useSearchParams()
    let statusParam = searchParams.get('status')
    let todoSearchParam = searchParams.get('search')
    let priorityParam = searchParams.get('priority')
    const [open,] = useState(false)
    const queryClient = useQueryClient()
    const navigate = useNavigate()
    let todoCount = 0
    const statusOptions = {}
    const priorityOptions = {}
    const [todoStatus, setTodoStatus] = useState(statusParam || 'not-completed')
    const [todoStatusName, setTodoStatusName] = useState('Not Completed')
    const [todoPriority, setTodoPriority] = useState(priorityParam || 'all')
    const [todoPriorityName, setTodoPriorityName] = useState('All')
    const [todoSearch, setTodoSearch] = useState('')
    let todos = []
    const [searchValue, setSearchValue] = useState('')
    const searchOptions = {
        findAllMatches: true,
        keys: ['post_content', 'post_title'],
        threshold: 0.3,
    }
    const { status, data, error, isFetching, isPreviousData } = useQuery({
        queryKey: ['todos'],
        queryFn: () => fetchTodos(),
        keepPreviousData: true,
        staleTime: 5000,
    })

    // Filters
    if (data) {

        todos = data.all_todos

        // Default show not completed
        if (statusParam === null || statusParam === 'not-completed') {
            todos = todos.filter(todo => todo.status !== 'completed')
        }

        // Filter by Status
        if (statusParam !== null && statusParam !== 'not-completed') {
            todos = todos.filter(todo => {
                if (statusParam === 'all') {
                    return todo
                }

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

        todoCount = todos.length

    }

    function updateTodoSearchParam (e) {
        console.log(e.target.value)
        if (e.target.value) {
            searchParams.set('search', e.target.value)
            setSearchParams(searchParams)
        } else {
            searchParams.delete('search')
            setSearchParams(searchParams)
        }

    }

    function updateStatus (e, newValue) {
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

    function updatePriority (e, newValue) {
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

                        To-Dos: {data && (
                        <>
                            <span>Status - {statusOptions[statusParam] || 'Not Completed'}</span>
                        </>
                    )}
                    </Typography>
                    <Box sx={{ flex: 999 }}/>
                    <Box
                        sx={{
                            display: 'flex',
                            gap: 1,
                            '& > *': { flexGrow: 1 },
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


                <Sheet
                    className="SearchAndFilters-mobile"
                    sx={{
                        display: {
                            xs: 'flex',
                            sm: 'none',
                        },
                        my: 1,
                        gap: 1,
                    }}
                >
                    <Input
                        size="sm"
                        placeholder="Search"
                        startDecorator={<Search className="feather"/>}
                        sx={{ flexGrow: 1 }}
                    />
                    <IconButton
                        size="sm"
                        variant="outlined"
                        color="neutral"
                        onClick={() => setOpen(true)}
                    >
                        <Filter className="feather"/>
                    </IconButton>
                    <Modal open={open} onClose={() => setOpen(false)}>
                        <ModalDialog
                            aria-labelledby="filter-modal"
                            layout="fullscreen"
                        >
                            <ModalClose/>
                            <Typography id="filter-modal" level="h2">
                                Filters
                            </Typography>
                            <Divider sx={{ my: 2 }}/>
                            <Sheet
                                sx={{
                                    display: 'flex',
                                    flexDirection: 'column',
                                    gap: 2,
                                }}
                            >
                                <Button
                                    color="primary"
                                    onClick={() => setOpen(false)}
                                >
                                    Submit
                                </Button>
                            </Sheet>
                        </ModalDialog>
                    </Modal>
                </Sheet>
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
                            <FormControl sx={{ flex: 1 }} size="sm">
                                <FormLabel>Search for To-do</FormLabel>
                                <Input
                                    placeholder="Search"
                                    startDecorator={<Search className="feather"/>}
                                    onChange={(e) => updateTodoSearchParam(e)}
                                />
                            </FormControl>


                            <FormControl size="sm">
                                <FormLabel>Status</FormLabel>
                                <Select
                                    slotProps={{ button: { sx: { whiteSpace: 'nowrap' } } }}
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
                                    slotProps={{ button: { sx: { whiteSpace: 'nowrap' } } }}
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
                            <th style={{ width: '15%', padding: '12px 20px' }}>
                                Status
                            </th>
                            <th style={{ width: '15%', padding: '12px 20px' }}>
                                Priority
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        {todos &&
                            todos.map((todo) => (
                                <tr key={todo.ID || todo.item.ID}>
                                    <td style={{ padding: 0 }}>
                                        <Link
                                            to={`/todos/${todo.ID || todo.item.ID}`}
                                            // to={'/'}
                                            state={todo}
                                            style={{
                                                textDecoration: 'none',
                                                display: 'block',
                                                width: '100%',
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
                                    <td>
                                        <Chip
                                            variant="soft"
                                            size="sm"
                                            // startDecorator={
                                            // 	{
                                            // 		Completed: (
                                            // 			<Check className="feather" />
                                            // 		),
                                            // 		'In Progress': (
                                            // 			<Activity className="feather" />
                                            // 		),
                                            // 		'Not Started': (
                                            // 			<BarChart2 className="feather" />
                                            // 		),
                                            // 	}[row.status]
                                            // }
                                            // color={
                                            // 	{
                                            // 		Completed: 'success',
                                            // 		'In Progress': 'info',
                                            // 		'Not Started': 'neutral',
                                            // 	}[row.status] as ColorPaletteProp
                                            // }
                                        >
                                            {todo.status_name}
                                        </Chip>
                                    </td>
                                    <td>
                                        <Chip
                                            variant="soft"
                                            size="sm"
                                        >
                                            {todo.priority_name}
                                        </Chip>
                                    </td>

                                </tr>
                            ))}
                        </tbody>
                    </Table>
                </Sheet>
            </div>
        </>
    )
}
