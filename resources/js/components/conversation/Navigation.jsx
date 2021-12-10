import React from "react";
import {Breadcrumb} from "react-bootstrap";
import {withTranslation} from "react-i18next";

class Navigation extends React.Component {
    render() {
        const {t} = this.props;

        return (
            <Breadcrumb>
                <Breadcrumb.Item href="/cc">
                    {t('navigation.home')}
                </Breadcrumb.Item>
            </Breadcrumb>
        );
    }
}

export default withTranslation()(Navigation);
