// Local Components
import SapphireTable from '../../dashboardComponents/SapphireTable/SapphireTable';
import {Activity, BarChart2, Check, Clock, Coffee, Feather, HelpCircle, Search, Shield, Truck} from "react-feather";
import {useSearchParams} from "react-router-dom";
import Input from '@mui/joy/Input'
import {useState} from "@wordpress/element";
import Select from "@mui/joy/Select";
import Option from "@mui/joy/Option";

export default function TodoTable() {
	const path = 'sapphire-site-manager/v1/todos';
	const query = {
		// page: page,
		// per_page: 100,
	};
	const queryKey = 'todos';
	const tableHead = [
		{
			label: 'Title',
			width: '40%',
		},
		{
			label: 'Status',
			width: '15%',
		},
		{
			label: 'Priority',
			width: '15%',
		},
	];
	const tableData = [
		{
			name: 'post_title'
		},
		{
			name: 'status_name',
			chip: {
				variant: 'outlined',
				startDecorator: {
					Completed: <Check className="feather"/>,
					'In Progress': <Activity className={`feather`}/>,
					Dependency: <HelpCircle className={`feather`}/>,
					'Not Started': <Feather className={`feather`}/>
				},
				color: {
					Completed: 'primary',
					'In Progress': 'success',
					Dependency: 'info',
					'Not Started': 'neutral'
				},
				value: 'status_name',
			},
		},
		{
			name: 'priority_name',
			chip: {
				variant: 'solid',
				startDecorator: {
					Low: <Truck className="feather"/>,
					Medium: <Shield className={`feather`}/>,
					High: <BarChart2 className={`feather`}/>,
					ASAP: <Clock className={`feather`}/>,
					'Not Set': <Coffee className={`feather`}/>
				},
				color: {
					Low: 'success',
					Medium: 'warning',
					High: 'danger',
					ASAP: 'info',
					'Not Set': 'neutral'
				},
				value: 'priority_name'
			},
		}
	];
	const allItems = 'all_todos'; // What we get from the endpoint

	const statusOptions = {}
	const searchOptions = {
		findAllMatches: true,
		keys: ['post_content', 'post_title'],
		threshold: 0.3,
	}
	let [searchParams, setSearchParams] = useSearchParams()
	let statusParam = searchParams.get('status')
	let todoSearchParam = searchParams.get('search')
	let priorityParam = searchParams.get('priority')
	const [todoPriority, setTodoPriority] = useState(priorityParam || 'all')
	const formControls = [
		{
			type: 'Input',
			attributes: {
				placeholder: 'Search',
				startDecorator: <Search className="feather"/>,
				onChange: function (e) {
					if (e.target.value) {
						searchParams.set('search', e.target.value)
						setSearchParams(searchParams)
					} else {
						searchParams.delete('search')
						setSearchParams(searchParams)
					}
				},
			},
			label: 'Search for To-do',
			field:
				<Input
					placeholder="search"
					startDecorator={<Search className="feather"/>}
					onChange={(e) => {
						if (e.target.value) {
							searchParams.set('search', e.target.value)
							setSearchParams(searchParams)
						} else {
							searchParams.delete('search')
							setSearchParams(searchParams)
						}
					}}
				/>,
		},
		{
			label: 'Priority',
			field:
				<Select
					slotProps={{button: {sx: {whiteSpace: 'nowrap'}}}}
					defaultValue={todoPriority}
					value={priorityParam || 'all'}
					onChange={(e, newValue) => {
						if (newValue) {
							setTodoPriority(newValue)

							searchParams.set('priority', newValue)
							setSearchParams(searchParams)
							// setSearchParams({ priority: newValue })
						}

						if (e) {
							setTodoStatusName(e.target.innerText)
						}
					}}
				>
					{
						Object.keys(statusOptions).map((oneKey, i) => {
							return (
								<Option key={oneKey} value={oneKey}>{statusOptions[oneKey]}</Option>
							)
						})
					}
				</Select>
		}

	];


	return (
		<SapphireTable
			path={path}
			query={query}
			className={'todo-page'}
			tableHead={tableHead}
			allItems={allItems}
			queryKey={queryKey}
			linkBase={'todos'}
			tableDataItems={tableData}
			formControls={formControls}
		/>
	);
}
