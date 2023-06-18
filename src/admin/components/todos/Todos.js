// Router
import {Link} from 'react-router-dom'

// JoyUI
import Box from '@mui/joy/Box'
import Button from '@mui/joy/Button'
import Typography from '@mui/joy/Typography'
import List from '@mui/joy/List'
import ListItem from '@mui/joy/ListItem'
import ListItemContent from '@mui/joy/ListItemContent'
import ListItemDecorator from '@mui/joy/ListItemDecorator'
import ListItemButton from '@mui/joy/ListItemButton'

// Icons
import {Plus, PlusSquare} from 'react-feather'

// Local Components
import TodoTable from './TodoTable'
import {useState} from "@wordpress/element";

export default function Todos() {

    return (
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
                    To-Dos
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
    )
}
