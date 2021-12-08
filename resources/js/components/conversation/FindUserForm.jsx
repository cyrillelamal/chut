import React from "react";
import {Form} from "react-bootstrap";
import {DebounceInput} from "react-debounce-input";


export default class FindUserForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            q: '',
        };
    }

    handleSubmit = (e) => {
        e.preventDefault;
    }

    handleChange = ({target}) => {
        const q = target.value.trim();
        this.props.handleChange(q);
    };

    render() {
        return (
            <Form onSubmit={this.handleSubmit}>
                <Form.Group className="input-group">
                    <DebounceInput
                        type="text"
                        className="form-control"
                        name="q"
                        placeholder={'Search for users'} // TODO: i18n
                        value={this.state.q}
                        onChange={this.handleChange}
                        debounceTimeout={490}
                        minLength={1}
                    />
                </Form.Group>
            </Form>
        );
    }
}
