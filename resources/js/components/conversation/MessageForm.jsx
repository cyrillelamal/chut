import React from "react";
import {Button, Form} from "react-bootstrap";
import {withTranslation} from "react-i18next";

class MessageForm extends React.Component {
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
        const {t} = this.props;

        return (
            <Form className="p-3" onSubmit={this.handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Control
                        as="textarea"
                        rows="4"
                        placeholder={t('conversation.message.start')}
                        value={this.state.body}
                        onChange={this.handleChange}
                    />
                </Form.Group>
                <Button variant="success" type="submit" onClick={this.handleSubmit}>
                    {t('conversation.message.send')}
                </Button>
            </Form>
        );
    }
}

export default withTranslation()(MessageForm);
