// WordPress
import apiFetch from '@wordpress/api-fetch'
import { addQueryArgs } from '@wordpress/url'
import { useEffect, useState } from '@wordpress/element'

// Router
import { Link } from 'react-router-dom'

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
import { ColorPaletteProp } from '@mui/joy/styles'

// Icons
import {
    ArrowLeft,
    ArrowRight,
    Filter,
    PlusSquare,
    Search,
    Clock,
    BarChart2,
    Truck,
    Shield,
    Coffee,
    Activity,
    HelpCircle,
    Check,
    CornerLeftDown,
    ChevronsRight,
    Feather
} from 'react-feather'

// Local Components
import TodoTable from '../components/todos/TodoTable'

export default function Todos () {
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

                <TodoTable/>
            </div>
        </>
    )
}
