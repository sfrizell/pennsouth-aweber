<?php
/**
 * AweberFieldsConstants.php
 * User: sfrizell
 * Date: 11/6/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\AweberEntity;


class AweberFieldsConstants
{
       const PATH_TO_AWEBER_UNDER_VENDOR                = '/vendor/aweber/aweber/aweber_api/aweber_api.php';
       const PRIMARY_RESIDENT_LIST                      = 'Primary Resident List'; // Unique List ID: awlist3774632
       const EMERGENCY_NOTICES_FOR_RESIDENTS            = 'Penn South Emergency Info Only'; // Unique List ID: awlist4464610 ; list_id is stripped of the 'awlist' prefix, just the # portion
       const FRIZELL_TEST_LIST                          = 'frizell_test';

       const CUSTOM_FIELDS                  = array('BUILDING' => 'Penn_South_Building',
                                                    'FLOOR_NUMBER' => 'Floor_Number',
                                                    'APARTMENT' => 'Apartment');

       const BUILDING                                           = 'Penn_South_Building';
       const FLOOR_NUMBER                                       = 'Floor_Number';
       const APARTMENT                                          = 'Apartment';
       const RESIDENT_CATEGORY                                  = 'resident_category';
       const TODDLER_ROOM_MEMBER                                = 'toddler_room_member';
       const YOUTH_ROOM_MEMBER                                  = 'youth_room_member';
       const CERAMICS_MEMBER                                    = 'ceramics_member';
       const WOODWORKING_MEMBER                                 = 'woodworking_member';
       const GYM_MEMBER                                         = 'gym_member';
       const GARDEN_MEMBER                                      = 'garden_member';
       const PARKING_LOT_LOCATION                               = 'parking_lot_location';
       const VEHICLE_REG_INTERVAL_REMAINING                     = 'vehicle_reg_interval_remaining';
       const HOMEOWNER_INS_INTERVAL_REMAINING                   = 'homeowner_ins_interval_remaining';
       const IS_DOG_IN_APT                                      = 'is_dog_in_apt';
       const STORAGE_LOCKER_CLOSET_BLDG_NUM                     = 'storage_locker_closet_bldg';
       const STORAGE_LOCKER_NUM                                 = 'storage_locker_num';
       const STORAGE_CLOSET_FLOOR_NUM                           = 'storage_closet_floor_num';
       const BIKE_RACK_BLDG                                     = 'bike_rack_bldg';
       const BIKE_RACK_ROOM                                     = 'bike_rack_room';
       const BIKE_RACK_LOCATION                                 = 'bike_rack_location';
       const PENN_SOUTH_AWEBER_ACCOUNT                          = 936765;
       const ADMINS_MDS_TO_AWEBER_LIST_ID                       = 4459191; // Aweber subscriber list of Penn South Administrators to receive emails about the running of this program to sync Aweber to MDS
       const PRIMARY_RESIDENT_LIST_ID                           = 3774632;
       const PENNSOUTH_EMERGENCY_NOTICES_FOR_RESIDENTS_LIST_ID  = 4464610;
       const FRIZELL_SUBSCRIBER_LIST_TEST_ID                    = 4390097; // just for testing...

       const PRIMARY_RESIDENT_LIST_URL                      = "/accounts/" . self::PENN_SOUTH_AWEBER_ACCOUNT . "/lists/" . self::PRIMARY_RESIDENT_LIST_ID;
       const PENNSOUTH_EMERGENCY_NOTICES_LIST_URL               = "/accounts/" . self::PENN_SOUTH_AWEBER_ACCOUNT . "/lists/" . self::PENNSOUTH_EMERGENCY_NOTICES_FOR_RESIDENTS_LIST_ID;
       const FRIZELL_SUBSCRIBER_LIST_TEST_URL               = "/accounts/" . self::PENN_SOUTH_AWEBER_ACCOUNT . "/lists/" . self::FRIZELL_SUBSCRIBER_LIST_TEST_ID;
       const AWEBER_MDS_SYNC_AUDIT_TABLE_NAME               = 'aweber_mds_sync_audit';


}