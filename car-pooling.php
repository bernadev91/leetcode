// https://leetcode.com/problems/car-pooling/
class Solution {

    /*
    There is a car with capacity empty seats. The vehicle only drives east (i.e., it cannot turn around and drive west).

    You are given the integer capacity and an array trips where trips[i] = [numPassengersi, fromi, toi] indicates that the ith trip has numPassengersi passengers and the locations to pick them up and drop them off are fromi and toi respectively. The locations are given as the number of kilometers due east from the car's initial location.

    Return true if it is possible to pick up and drop off all passengers for all the given trips, or false otherwise.

    Constraints:

    1 <= trips.length <= 1000
    trips[i].length == 3
    1 <= numPassengersi <= 100
    0 <= fromi < toi <= 1000
    1 <= capacity <= 105

    */

    /**
     * @param int[][] $trips
     * @param int $capacity
     * @return Boolean
     */
    function carPooling($trips, $capacity)
    {
        $current_stop = 0;
        $people_in_car = 0;
        $drop_offs = [];

        for ($i=0; $i <= 1000; $i++)
        {
            $drop_offs[$i] = 0;
        }

        // first, order by the starting point
        usort($trips, function($tripA, $tripB) {
            return $tripA[1] > $tripB[1];
        });

        // go through each trip knowing that the next one starts later
        foreach ($trips as $trip)
        {
            list($numPassengersi, $fromi, $toi) = $trip;

            $current_stop = $fromi;

            // echo 'I start with '.$people_in_car.' people at point '.$fromi.PHP_EOL;

            // mark where they're leaving
            $drop_offs[$toi] += $numPassengersi;

            // someone is leaving in this stop
            if ($drop_offs[$current_stop] > 0)
            {
                // echo $drop_offs[$current_stop].' people leaving at this stop'.PHP_EOL;
                $people_in_car -= $drop_offs[$current_stop];
                $drop_offs[$current_stop] = 0;
            }

            // check if people wanted to leave before
            foreach ($drop_offs as $position => $people_leaving)
            {
                if ($people_leaving > 0)
                {
                    if ($position <= $fromi)
                    {
                        // echo $people_leaving.' people left earlier already'.PHP_EOL;
                        $people_in_car -= $people_leaving;
                        $drop_offs[$position] = 0;
                    }
                }
            }

            // someone is entering the car now
            $people_in_car += $numPassengersi;

            // echo $people_in_car.'<---'.PHP_EOL;
            // echo '-----------'.PHP_EOL;

            // check if the people who entered fit
            if ($people_in_car > $capacity)
            {
                return FALSE;
            }
        }

        return true;
    }
}
