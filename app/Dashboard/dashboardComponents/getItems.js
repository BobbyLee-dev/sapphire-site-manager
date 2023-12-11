import apiFetch from "@wordpress/api-fetch";
import {addQueryArgs} from "@wordpress/url";
import {useQuery} from "react-query";

export default function getItems(path = '', query = {}, queryKey = '') {
	const {status, data, error, isFetching, isPreviousData} = useQuery({
		queryKey: [queryKey],
		queryFn: () => apiFetch({
			path: addQueryArgs(path, query),
			method: 'GET',
			parse: false,
		}).then((response) => {
			return response.json().then((data) => {
				return data
			})
		}),
		keepPreviousData: true,
		staleTime: 5000,
	})

	return data;
}
