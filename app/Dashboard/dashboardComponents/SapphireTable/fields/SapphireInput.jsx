export default function SapphireInput(props) {
	return (
		<SapphireInput
			// placeholder="search"
			// startDecorator={<Search className="feather"/>}
			// onChange={(e) => props.handleChange(e)}
			{...props.attributes}
		/>
	)
}
