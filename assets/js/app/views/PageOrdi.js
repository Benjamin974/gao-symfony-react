import React from 'react';
import { Container, Row, Col } from 'reactstrap';
import CardOrdi from '../components/CardOrdi';
import AddOrdi from '../components/AddOrdi'
import DatePicker from '../components/DatePicker'
import eventBus from './eventBus';
import { apiService } from '../_services/apiService';

class PageOrdi extends React.Component {
    constructor(props) {
        super(props)
        this.state = { ordinateurs: [], date: new Date().toISOString().substr(0, 10), }
        this.handleDate = this.handleDate.bind(this);
        this.add = this.add.bind(this);
    }

    componentDidMount() {
        this.fetchOrdis();
        eventBus.on("addOrdi", (data) => {
            this.add(data);
        }
        );

    }

    componentWillUnmount() {
        eventBus.remove("addOrdi");
    }

    fetchOrdis() {

        apiService.post(`ordinateurs/get`, { date: this.state.date, page: 1 })
            .then(({ data }) => {
                this.setState({
                    ordinateurs: data,
                });
            })

    }

    handleDate(dateValue) {

        this.setState({ ordinateurs: [], date: dateValue.toISOString().substr(0, 10) });
        apiService.post(`ordinateurs/get`, { date: dateValue, page: 1 })
        .then(({ data }) => {
            this.setState({
                ordinateurs: data,
            });
        })
    }

    add(data) {
        // var newStateArray = this.state.ordinateurs.slice();
        // newStateArray.push(data.name);
        this.setState({ordinateurs: [...this.state.ordinateurs, data.name]});

    }



    render() {

        return (
            <Container>
                <DatePicker onSelectDate={this.handleDate} />
                <AddOrdi ordinateurs={this.state.ordinateurs} />
                <Row>
                    {this.state.ordinateurs.map((item, i) => (
                        <Col xs="6" sm="4" key={i}>
                            <CardOrdi date={this.state.date} item={item} />
                        </Col>
                    ))}
                </Row>
            </Container>


        );
    }
}



export default PageOrdi;