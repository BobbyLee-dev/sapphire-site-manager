import apiFetch from "@wordpress/api-fetch";
import {addQueryArgs} from "@wordpress/url";

export default function getItems(path = '', query = {}) {
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
