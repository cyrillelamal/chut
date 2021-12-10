import React from "react";
import {Form, Row} from "react-bootstrap";
import {DebounceInput} from "react-debounce-input";
import {findUsers} from "../../services/users";
import UserPreview from "./UserPreview";
import {withTranslation} from "react-i18next";
import {bottom} from "../../services/pagination";

class UserPicker extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            users: [],
            page: 1,
            last_page: null,
            q: '',
        };
    }

    handleSubmit = (e) => {
        e.preventDefault();
        e.stopPropagation();
    }

    handleChange = (e) => {
        const q = e.target.value.trim();

        const state = {users: [], page: 1, last_page: null, q};

        if (q.length) {
            findUsers(q, 1)
                .then(
                    ({data, meta}) => this.setState({users: data, last_page: meta.last_page, q})
                );
        } else {
            this.setState(state);
        }
    }

    handleScroll = ({target}) => {
        if (bottom(target)) { // bottom
            this.setState(
                (state) => {
                    const {page, last_page, q} = state;

                    if (last_page <= page) { // no more items.
                        return {page: last_page};
                    }

                    findUsers(q, page + 1)
                        .then(
                            ({data: users, meta}) => this.setState(
                                (state) => ({last_page: meta.last_page, users: [...state.users, ...users]})
                            )
                        );

                    return {page: page + 1};
                }
            );
        }
    }

    handleSelect = (id) => {
        const user = this.state.users.find(u => u.id === id);
        user && this.props.handleSelect && this.props.handleSelect(user);
    }

    userPreview = (user) => <UserPreview key={user.id} {...user} handleSelect={this.handleSelect}/>;

    render() {
        const {t} = this.props;

        return (
            <div className="h-100 d-flex flex-column p-4">
                <Form onSubmit={this.handleSubmit}>
                    <Form.Group className="input-group">
                        <DebounceInput
                            type="search"
                            className="form-control"
                            name="q"
                            placeholder={t('user.search_for')}
                            value={this.state.q}
                            onChange={this.handleChange}
                            debounceTimeout={510}
                            minLength={1}
                            autoComplete="off"
                        />
                    </Form.Group>
                </Form>
                <Row className="flex-grow-1 overflow-auto p-3 mt-3" onScroll={this.handleScroll}>
                    {this.state.users.map(this.userPreview)}
                </Row>
            </div>
        );
    }
}

export default withTranslation()(UserPicker);
