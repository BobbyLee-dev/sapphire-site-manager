// WordPress
import apiFetch from '@wordpress/api-fetch'
import {addQueryArgs} from "@wordpress/url";
import {useEffect, useState} from "@wordpress/element";

// Router
import {Link, useNavigate} from 'react-router-dom'

// React Query
import {useQuery, useQueryClient} from 'react-query'

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
import IconButton, {iconButtonClasses} from '@mui/joy/IconButton'
import Typography from '@mui/joy/Typography'

// Icons
import {
    ArrowLeft,
    ArrowRight,
    Filter,
    Search,
} from 'react-feather'


// Local Components
function renderFilters() {
    (
        <>
            <FormControl size="sm">
                <FormLabel>Status</FormLabel>
                <Select
                    placeholder="Filter by status"
                    slotProps={{button: {sx: {whiteSpace: 'nowrap'}}}}
                >
                    <Option value="all">All</Option>
                    <Option value="in-progress">In Progress</Option>
                    <Option value="completed">Completed</Option>
                    <Option value="not-started">Not Started</Option>
                    <Option value="blocked">Blocked</Option>
                    <Option value="back-log">Back Log</Option>
                </Select>
            </FormControl>

            <FormControl size="sm">
                <FormLabel>Category</FormLabel>
                <Select placeholder="All">
                    <Option value="all">All</Option>
                </Select>
            </FormControl>
        </>
    )
}

function fetchTodos(page = 1, per_page = 10) {
    let path = 'wp/v2/sapphire_sm_todo'

    const query = {
        page: page,
        per_page: per_page,
    };

    return apiFetch({
        path: addQueryArgs(path, query),
        method: 'GET',
        parse: false,
    }).then((response) => {
        return response.json().then((data) => {
            return {
                todos: data,
                totalPages: response.headers.get('X-WP-TotalPages'),
                totalTodos: response.headers.get('X-WP-Total')
            }
        })
    });
}


export default function OrderTable() {
    const [open,] = useState(false)
    const [page, setPage] = useState(1)
    const queryClient = useQueryClient()
    const navigate = useNavigate();

    const {status, data, error, isFetching, isPreviousData} = useQuery({
        queryKey: ['todos', page],
        queryFn: () => fetchTodos(page),
        keepPreviousData: true,
        staleTime: 5000,
    })
    console.log(page)

    const hasNext = data?.totalPages > page
    console.log(hasNext)


    console.log(data)

    // console.log(hasNext)

    // Prefetch the next page!
    useEffect(() => {
        if (!isPreviousData && hasNext) {
            queryClient.prefetchQuery({
                queryKey: ['todos', page + 1],
                queryFn: () => fetchTodos(page + 1),
            })
        }
    }, [data, isPreviousData, page, queryClient])

    return (
        <>
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
                    sx={{flexGrow: 1}}
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
                        <Divider sx={{my: 2}}/>
                        <Sheet
                            sx={{
                                display: 'flex',
                                flexDirection: 'column',
                                gap: 2,
                            }}
                        >
                            {renderFilters()}
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
                <FormControl sx={{flex: 1}} size="sm">
                    <FormLabel>Search for To-do</FormLabel>
                    <Input
                        placeholder="Search"
                        startDecorator={<Search className="feather"/>}
                    />
                </FormControl>

                {renderFilters()}
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
                                width: '50%',
                                padding: '12px 20px',
                                height: 'auto',
                            }}
                        >
                            Title
                        </th>
                        <th style={{width: '25%', padding: '12px 20px'}}>
                            Status
                        </th>
                        <th style={{width: '15%', padding: '12px 20px'}}>
                            Date
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {data &&
                        data.todos.map((todo) => (
                            <tr key={todo.id}>
                                <td style={{padding: 0}}>
                                    <Link
                                        to={`/todos/${todo.id}`}
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
                                            {todo.title.rendered}
                                        </Typography>
                                    </Link>
                                </td>
                                {/* <td>
									<Chip
										variant="soft"
										size="sm"
										startDecorator={
											{
												Completed: (
													<Check className="feather" />
												),
												'In Progress': (
													<Activity className="feather" />
												),
												'Not Started': (
													<BarChart2 className="feather" />
												),
											}[row.status]
										}
										color={
											{
												Completed: 'success',
												'In Progress': 'info',
												'Not Started': 'neutral',
											}[row.status] as ColorPaletteProp
										}
									>
										{row.status}
									</Chip>
								</td>
								<td>{row.date}</td> */}
                            </tr>
                        ))}
                    </tbody>
                </Table>
            </Sheet>
            <Box
                className="Pagination-mobile"
                sx={{
                    display: {xs: 'flex', md: 'none'},
                    alignItems: 'center',
                }}
            >
                <IconButton
                    aria-label="previous page"
                    variant="outlined"
                    color="neutral"
                    size="sm"
                >
                    <ArrowLeft className="feather"/>
                </IconButton>
                <Typography level="body2" mx="auto">
                    Page 1 of 10
                </Typography>
                <IconButton
                    aria-label="next page"
                    variant="outlined"
                    color="neutral"
                    size="sm"
                >
                    <ArrowRight className="feather"/>
                </IconButton>
            </Box>
            <Box
                className="Pagination-laptopUp"
                sx={{
                    pt: 4,
                    gap: 1,
                    [`& .${iconButtonClasses.root}`]: {borderRadius: '50%'},
                    display: {
                        xs: 'none',
                        md: 'flex',
                    },
                }}
            >
                <Button
                    size="sm"
                    variant="plain"
                    color="neutral"
                    startDecorator={<ArrowLeft className="feather"/>}
                    onClick={() => setPage((old) => Math.max(old - 1, 0))}
                    disabled={page === 1}
                >
                    Previous
                </Button>

                {/*<Box sx={{flex: 1}}/>*/}
                {/*{['1', '2', '3', '…', '8', '9', '10'].map((page) => (*/}
                {/*    <IconButton*/}
                {/*        key={page}*/}
                {/*        size="sm"*/}
                {/*        variant={Number(page) ? 'outlined' : 'plain'}*/}
                {/*        color="neutral"*/}
                {/*    >*/}
                {/*        {page}*/}
                {/*    </IconButton>*/}
                {/*))}*/}
                {/*{*/}
                {/*    // Since the last page's data potentially sticks around between page requests,*/}
                {/*    // we can use `isFetching` to show a background loading*/}
                {/*    // indicator since our `status === 'loading'` state won't be triggered*/}
                {/*    isFetching ? <span> Loading...</span> : null*/}
                {/*}{' '}*/}
                <Box sx={{flex: 1}}/>

                <Button
                    size="sm"
                    variant="plain"
                    color="neutral"
                    endDecorator={<ArrowRight className="feather"/>}
                    onClick={() => {
                        setPage((old) => (hasNext ? old + 1 : old))
                    }}
                    disabled={isPreviousData || !hasNext}
                >
                    Next
                </Button>
            </Box>
        </>
    )
}
