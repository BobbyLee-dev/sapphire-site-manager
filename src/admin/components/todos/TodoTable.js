// WordPress
import apiFetch from '@wordpress/api-fetch'
import { addQueryArgs } from '@wordpress/url'
import { useEffect, useState } from '@wordpress/element'

// Router
import { Link, useNavigate, useSearchParams, useParams } from 'react-router-dom'

// TanStack React Query
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

export default function OrderTable () {
    const parentRef = React.useRef()
    let [searchParams, setSearchParams] = useSearchParams()
    let statusParam = searchParams.get('status')
    const [open,] = useState(false)
    const queryClient = useQueryClient()
    const navigate = useNavigate()
    let todoCount = 0

    const statusOptions = {
        'not-completed': 'Not Completed',
        'in-progress': 'In Progress',
        'not-started': 'Not Started',
        'needs-review': 'Needs Review',
        'completed': 'Completed',
        'back-log': 'Back Log',
        'all': 'All'
    }

    const [todoStatus, setTodoStatus] = useState(statusParam || 'not-completed')
    const [todoStatusName, setTodoStatusName] = useState(statusOptions[statusParam] || 'Not Completed')

    const { status, data, error, isFetching, isPreviousData } = useQuery({
        queryKey: ['todos'],
        queryFn: () => fetchTodos(),
        keepPreviousData: true,
        staleTime: 5000,
    })

    let todos = data

    if (todos) {

        // Default show not completed
        if (statusParam === null || statusParam === 'not-completed') {
            todos = todos.filter(todo => todo.status !== 'completed')
        }

        // Show status selected
        if (statusParam !== null && statusParam !== 'not-completed') {
            todos = todos.filter(todo => {
                if (statusParam === 'all') {
                    return todo
                }

                return todo.status === statusParam

            })
        }

        todoCount = todos.length
    }

    function updateStatus (e, newValue) {
        setTodoStatus(newValue)
        setTodoStatusName(e.target.innerText)
        setSearchParams({ status: newValue })
    }

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
                        To-Dos: {statusOptions[statusParam] || 'Not Completed'} {todoCount !== 0 && (`(${todoCount})`)}
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
