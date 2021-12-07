import React from "react";

export default class AbstractInput extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            value: '',
        };
    };

    handleChange = ({target}) => {
        const {name, value} = target;
        this.props.hasOwnProperty('handleChange') && this.props.handleChange({name, value});
        this.setState({value});
    };
}
