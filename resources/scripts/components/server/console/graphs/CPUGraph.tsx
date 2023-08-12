import React, { useEffect, useRef } from 'react';
import { ServerContext } from '@/state/server';
import { SocketEvent } from '@/components/server/events';
import useWebsocketEvent from '@/plugins/useWebsocketEvent';
import { Line } from 'react-chartjs-2';
import { useChartTickLabel } from '@/components/server/console/graphs/chart';

export default () => {
    const status = ServerContext.useStoreState((state) => state.status.value);
    const limits = ServerContext.useStoreState((state) => state.server.data!.limits);

    const cpu = useChartTickLabel('CPU', limits.cpu, '%', 2);

    useEffect(() => {
        if (status === 'offline') {
            cpu.clear();
        }
    }, [status]);

    useWebsocketEvent(SocketEvent.STATS, (data: string) => {
        let values: any = {};
        try {
            values = JSON.parse(data);
        } catch (e) {
            return;
        }

        cpu.push(values.cpu_absolute);
    });

    return (
        <div className={`w-full`}>
            <Line {...cpu.props} />
        </div>
    );
};
