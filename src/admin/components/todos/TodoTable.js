// WordPress
import apiFetch from '@wordpress/api-fetch'
import { addQueryArgs } from '@wordpress/url'
import { useEffect, useState } from '@wordpress/element'

// Router
import { Link, useNavigate, useSearchParams, useParams } from 'react-router-dom'

// React Query
import { useQuery, useQueryClient } from 'react-query'

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

function fetchTodos (page = 1, per_page = 10) {

    let path = 'sapphire-site-manager/v1/todos'
    const query = {
        page: page,
        per_page: 100,
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

export default function OrderTable () {
    let [searchParams, setSearchParams] = useSearchParams()
    let statusParam = searchParams.get('status')
    const [open,] = useState(false)
    const [page, setPage] = useState(1)
    const queryClient = useQueryClient()
    const navigate = useNavigate()
    const [todoStatus, setTodoStatus] = useState(statusParam || 'sapphire-todo-status-in-progress')
    const [todoStatusName, setTodoStatusName] = useState('All')
    let todoCount = 0

    const { status, data, error, isFetching, isPreviousData } = useQuery({
        queryKey: ['todos', page],
        queryFn: () => fetchTodos(page),
        keepPreviousData: true,
        staleTime: 5000,
    })

    function updateStatus (e, newValue) {
        setTodoStatus(newValue)
        setTodoStatusName(e.target.innerText)
        setSearchParams({ status: newValue })
    }

    let todos = data
    if (todos) {
        if (statusParam) {
            todos = todos.filter(todo => todo.status === statusParam)
        }

        todoCount = todos.length
    }
    console.log(searchParams.get('status'))

    return (
        <>
            <div className={`todo-page`}>
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
                        To-Dos: {todoStatusName} ({todoCount})
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
                    <FormControl sx={{ flex: 1 }} size="sm">
                        <FormLabel>Search for To-do</FormLabel>
                        <Input
                            placeholder="Search"
                            startDecorator={<Search className="feather"/>}
                        />
                    </FormControl>

                    <FormControl size="sm">
                        <FormLabel>Status</FormLabel>
                        <Select
                            // placeholder="Filter by status"
                            slotProps={{ button: { sx: { whiteSpace: 'nowrap' } } }}
                            // onChange={(e, newValue) => setTodoStatus(newValue)}
                            defaultValue={`sapphire-todo-status-in-progress`}
                            onChange={(e, newValue) => updateStatus(e, newValue)}
                        >
                            <Option value="sapphire-todo-status-in-progress">In Progress</Option>
                            <Option value="sapphire-todo-status-not-started">Not Started</Option>
                            <Option value="sapphire-todo-status-needs-review">Needs Review</Option>
                            <Option value="sapphire-todo-status-completed">Completed</Option>
                            <Option value="sapphire-todo-status-blocked">Blocked</Option>
                            <Option value="sapphire-todo-status-back-log">Back Log</Option>
                            <Option value="all">All</Option>
                        </Select>
                    </FormControl>

                    <FormControl size="sm">
                        <FormLabel>Priority</FormLabel>
                        <Select
                            placeholder="Filter by priority"
                            slotProps={{ button: { sx: { whiteSpace: 'nowrap' } } }}
                        >
                            <Option value="all">All</Option>
                            <Option value="in-prog">High</Option>
                            <Option value="completed">Med</Option>
                            <Option value="not-started">Low</Option>
                            <Option value="blocked">Not Set</Option>
                        </Select>
                    </FormControl>
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
                                <tr key={todo.ID}>
                                    <td style={{ padding: 0 }}>
                                        <Link
                                            to={`/todos/${todo.ID}`}
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
                                                {todo.post_title}
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
                                            {todo.status_name}
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
