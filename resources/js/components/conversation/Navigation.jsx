import React from "react";
import {Breadcrumb} from "react-bootstrap";

export default class Navigation extends React.Component {
    render() {
        return (
            <Breadcrumb>
                <Breadcrumb.Item href="/cc">
                    {'Home'}{/* TODO: i18n */}
                </Breadcrumb.Item>
            </Breadcrumb>
        );
    }
}
