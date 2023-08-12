import React, { useEffect, useRef } from 'react';
import { ServerContext } from '@/state/server';
import { SocketEvent } from '@/components/server/events';
import useWebsocketEvent from '@/plugins/useWebsocketEvent';
import { Line } from 'react-chartjs-2';
import { useChartTickLabel } from '@/components/server/console/graphs/chart';

export default () => {
    const status = ServerContext.useStoreState((state) => state.status.value);
    const limits = ServerContext.useStoreState((state) => state.server.data!.limits);

    const memory = useChartTickLabel('Memory', limits.memory, 'MB');

    useEffect(() => {
        if (status === 'offline') {
            memory.clear();
        }
    }, [status]);

    useWebsocketEvent(SocketEvent.STATS, (data: string) => {
        let values: any = {};
        try {
            values = JSON.parse(data);
        } catch (e) {
            return;
        }

        memory.push(Math.floor(values.memory_bytes / 1024 / 1024));
    });

    return (
        <div className={`w-full`}>
            <Line {...memory.props} />
        </div>
    );
};
