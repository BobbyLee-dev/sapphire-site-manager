// JoyUI
import Box from '@mui/joy/Box'
import Button from '@mui/joy/Button'
import Typography from '@mui/joy/Typography'
import Link from '@mui/joy/Link'
import List from '@mui/joy/List'
import ListItem from '@mui/joy/ListItem'
import ListItemContent from '@mui/joy/ListItemContent'
import ListItemDecorator from '@mui/joy/ListItemDecorator'
import ListItemButton from '@mui/joy/ListItemButton'

// Icons
import { Plus, PlusSquare } from 'react-feather'

// Local Components
import TodoTable from './TodoTable'

export default function Todos () {
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
                    To-Dos
                </Typography>
                <Box sx={{ flex: 999 }}/>
                <Box
                    sx={{
                        display: 'flex',
                        gap: 1,
                        '& > *': { flexGrow: 1 },
                    }}
                >
                    <Button
                        component="a"
                        href="https://tiempo.localhost.com/wp-admin/post-new.php?post_type=sapphire_sm_todo"
                        // level="body2"
                        color="primary"
                        variant="soft"
                        underline="none"
                        endDecorator={<PlusSquare className="feather"/>}
                    >
                        Add To-Do
                    </Button>
                </Box>
            </Box>
            <TodoTable/>
            {/*<iframe height="1000" frameBorder="0" width="1000"*/}
            {/*        src={`https://tiempo.localhost.com/wp-admin/post-new.php?post_type=sapphire_sm_todo`}/>*/}
        </>
    )
}
