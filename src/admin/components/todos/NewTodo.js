// Router
import {Link} from 'react-router-dom'

// Icons
import Button from "@mui/joy/Button";

export default function NewTodo() {

    return (
        <div className={`add-sapphire-todo-container`}>

            <Link
                className={`add-todo-back-btn`}
                to="/todos"
                style={{
                    textDecoration: 'none',

                }}
            >
                Back
            </Link>
            <div className="loading">
                Loading...
            </div>
            <iframe src={`${window.location.origin}/wp-admin/post-new.php?post_type=sapphire_sm_todo`}/>
        </div>
    )

}