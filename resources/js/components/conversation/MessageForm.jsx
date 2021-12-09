import React from "react";
import {Button, Form} from "react-bootstrap";

export default class MessageForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            body: '',
        };
    }

    handleSubmit = (e) => {
        e.preventDefault();

        const body = this.state.body.trim();

        if (body.length < 1) {
            return;
        }

        this.props.send && this.props.send(body);
        this.setState({body: ''});
    }

    handleChange = (e) => {
        this.setState({body: e.target.value});
    }

    render() {
        return (
            <Form className="p-3" onSubmit={this.handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Control
                        as="textarea"
                        rows="4"
                        placeholder={'Start typing'} // TODO: i18n
                        value={this.state.body}
                        onChange={this.handleChange}
                    />
                </Form.Group>
                <Button variant="success" type="submit" onClick={this.handleSubmit}>
                    {'Send'}{/* TODO: i18n */}
                </Button>
            </Form>
        );
    }
}
