import React from "react";
import {Button, Card, Form} from "react-bootstrap";
import {sendPrivateMessage} from "../../services/messages";

export default class UserMessageForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            body: '',
            submitted: false,
            invalid: false,
        };
    }

    handleSubmit = (e) => {
        e.preventDefault();

        const {body} = this.state;

        if (body.length < 1) {
            return this.setState({invalid: true});
        }

        this.setState({submitted: true});
        sendPrivateMessage(this.id, body)
            .then(() => this.setState({body: ''}))
            .finally(() => this.setState({submitted: false}));
    }

    handleChange = ({target}) => {
        this.setState({body: target.value, invalid: false});
    }

    render() {
        return (
            <Card>
                <Card.Body>
                    <Card.Title>{this.name}</Card.Title>
                    <Card.Subtitle>{this.email}</Card.Subtitle>
                    <Form onSubmit={this.handleSubmit}>
                        <Form.Group className="my-3">
                            <Form.Control
                                as="textarea"
                                rows="3"
                                className={this.state.invalid ? 'is-invalid' : ''}
                                placeholder={this.placeholder}
                                name="body"
                                value={this.state.body}
                                onChange={this.handleChange}
                                disabled={this.state.submitted}
                            />
                        </Form.Group>
                        <Button variant="primary" type="submit" disabled={this.state.submitted}>
                            {'Send'}{/* TODO: i18n */}
                        </Button>
                    </Form>
                </Card.Body>
            </Card>
        );
    }

    get id() {
        return this.props.hasOwnProperty('id') ? this.props.id : '';
    }

    get name() {
        return this.props.hasOwnProperty('name') ? this.props.name : '';
    }

    get email() {
        return this.props.hasOwnProperty('email') ? this.props.email : '';
    }

    get placeholder() {
        return `Write message to ${this.name}`; // TODO: i18n
    }
}
