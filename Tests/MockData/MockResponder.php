<?php namespace CarouselTests\MockData;

class MockResponder
{
  public function whoAmI()
  {
    $data = [
      'id' => 'admin',
      'FirstName' => 'Seth',
      'LastName' => 'Phillips',
      'EmailAddress'=> 'test@email.com',
      'DefaultZoneID'=> 1,
      'IsAdmin'=> true,
      'SystemRights'=> [],
      'ZoneRights' => []
    ];

    return json_encode([$data]);
  }



  public function bulletins()
  {
    $data = [
      [
        "id"=> "1",
        "GroupID"=> "1",
        "UserID"=> "admin",
        "IsAlert"=> true,
        "Status"=> "Current",
        "Type"=> "Standard",
        "Description"=> "This is a test bulletin",
        "DateTimeOn"=> "2017-07-07T14:20:57.191Z",
        "DateTimeOff"=> "2017-07-07T14:20:57.191Z",
        "CycleTimeOff"=> "2017-07-07T14:20:57.191Z",
        "CycleTimeOn"=> "2017-07-07T14:20:57.191Z",
        "WeekdayOnOff"=> 64,
        "WeekdayOnOffDescription"=> "Every Day",
        "IsRepeating"=> true,
        "RepeatInterval"=> 0,
        "IsScheduled"=> false,
        "LastUpdate"=> "2017-07-07T14:20:57.191Z",
        "ImpressionCount"=> 0,
        "TrackImpressions"=> true,
        "LastError"=> "string",
        "Tags"=> [
          [
            "id"=> 1,
            "TagName"=> "Test Tag"
          ]
        ],
        "TransitionID"=> "1",
        "UseSystemDwellTime"=> true,
        "DwellTime"=> 0,
        "SoundID"=> "1",
        "WebEnabled"=> true,
        "Notified"=> true,
        "CustomDescription"=> true,
        "SuppressBackgroundAudio"=> true,
        "IsDeleted"=> false,
        "IsMigrated"=> true,
        "IsCorrupt"=> false,
        "BackgroundID"=> "1",
        "Blocks"=> [
          [
            "BlockType"=> "Rectangle",
            "Height"=> 0,
            "Width"=> 0,
            "X"=> 0,
            "Y"=> 0,
            "RectColor"=> "string",
            "RectColorOpacity"=> 0,
            "RectShadow"=> true,
            "RectShadowColor"=> "string",
            "RectShadowOpacity"=> 0,
            "RectShadowDepth"=> 0,
            "RectOutline"=> true,
            "RectOutlineColor"=> "string",
            "RectOutlineOpacity"=> 0,
            "RectOutlineWidth"=> 0,
            "RectGradient"=> true,
            "RectGradientMode"=> "BackwardDiagonal",
            "RectGradientColor"=> "string",
            "RectGradientOpacity"=> 0,
            "RotateDegrees"=> 0,
            "Reflection"=> true,
            "ReflectionOpacity"=> 0,
            "ReflectionOffset"=> 0,
            "ReflectionHeight"=> 0,
            "Name"=> "string",
            "HTMLFieldType"=> "EditField",
            "HTMLFieldSize"=> "Small",
            "RepeatType"=> "Header"
          ]
        ],
      ],
      [
        "id"=> "2",
        "GroupID"=> "2",
        "UserID"=> "admin",
        "IsAlert"=> true,
        "Status"=> "Current",
        "Type"=> "Standard",
        "Description"=> "This is a test bulletin",
        "DateTimeOn"=> "2017-07-07T14:20:57.191Z",
        "DateTimeOff"=> "2017-07-07T14:20:57.191Z",
        "CycleTimeOff"=> "2017-07-07T14:20:57.191Z",
        "CycleTimeOn"=> "2017-07-07T14:20:57.191Z",
        "WeekdayOnOff"=> 127,
        "WeekdayOnOffDescription"=> "Every Day",
        "IsRepeating"=> false,
        "RepeatInterval"=> 0,
        "IsScheduled"=> false,
        "LastUpdate"=> "2017-07-07T14:20:57.191Z",
        "ImpressionCount"=> 0,
        "TrackImpressions"=> true,
        "LastError"=> "string",
        "Tags"=> [
          [
            "id"=> 1,
            "TagName"=> "Test Tag"
          ]
        ],
        "TransitionID"=> "1",
        "UseSystemDwellTime"=> true,
        "DwellTime"=> 0,
        "SoundID"=> "1",
        "WebEnabled"=> true,
        "Notified"=> true,
        "CustomDescription"=> true,
        "SuppressBackgroundAudio"=> true,
        "IsDeleted"=> false,
        "IsMigrated"=> true,
        "IsCorrupt"=> false,
        "BackgroundID"=> "1",
        "Blocks"=> [
          [
            "BlockType"=> "Rectangle",
            "Height"=> 0,
            "Width"=> 0,
            "X"=> 0,
            "Y"=> 0,
            "RectColor"=> "string",
            "RectColorOpacity"=> 0,
            "RectShadow"=> true,
            "RectShadowColor"=> "string",
            "RectShadowOpacity"=> 0,
            "RectShadowDepth"=> 0,
            "RectOutline"=> true,
            "RectOutlineColor"=> "string",
            "RectOutlineOpacity"=> 0,
            "RectOutlineWidth"=> 0,
            "RectGradient"=> true,
            "RectGradientMode"=> "BackwardDiagonal",
            "RectGradientColor"=> "string",
            "RectGradientOpacity"=> 0,
            "RotateDegrees"=> 0,
            "Reflection"=> true,
            "ReflectionOpacity"=> 0,
            "ReflectionOffset"=> 0,
            "ReflectionHeight"=> 0,
            "Name"=> "string",
            "HTMLFieldType"=> "EditField",
            "HTMLFieldSize"=> "Small",
            "RepeatType"=> "Header"
          ]
        ],
      ]
    ];

    return json_encode($data);
  }

  public function bulletin()
  {
    $data = [
      "id"=> "1",
      "GroupID"=> "1",
      "UserID"=> "admin",
      "IsAlert"=> true,
      "Status"=> "Current",
      "Type"=> "Standard",
      "Description"=> "This is a test bulletin",
      "DateTimeOn"=> "2017-07-07T14:20:57.191Z",
      "DateTimeOff"=> "2017-07-07T14:20:57.191Z",
      "CycleTimeOff"=> "2017-07-07T14:20:57.191Z",
      "CycleTimeOn"=> "2017-07-07T14:20:57.191Z",
      "WeekdayOnOff"=> 64,
      "WeekdayOnOffDescription"=> "Every Day",
      "IsRepeating"=> true,
      "RepeatInterval"=> 0,
      "IsScheduled"=> false,
      "LastUpdate"=> "2017-07-07T14:20:57.191Z",
      "ImpressionCount"=> 0,
      "TrackImpressions"=> true,
      "LastError"=> "string",
      "Tags"=> [
        [
          "id"=> 1,
          "TagName"=> "Test Tag"
        ]
      ],
      "TransitionID"=> "1",
      "UseSystemDwellTime"=> true,
      "DwellTime"=> 0,
      "SoundID"=> "1",
      "WebEnabled"=> true,
      "Notified"=> true,
      "CustomDescription"=> true,
      "SuppressBackgroundAudio"=> true,
      "IsDeleted"=> false,
      "IsMigrated"=> true,
      "IsCorrupt"=> false,
      "BackgroundID"=> "1",
      "Blocks"=> [
        [
          "BlockType"=> "Rectangle",
          "Height"=> 0,
          "Width"=> 0,
          "X"=> 0,
          "Y"=> 0,
          "RectColor"=> "string",
          "RectColorOpacity"=> 0,
          "RectShadow"=> true,
          "RectShadowColor"=> "string",
          "RectShadowOpacity"=> 0,
          "RectShadowDepth"=> 0,
          "RectOutline"=> true,
          "RectOutlineColor"=> "string",
          "RectOutlineOpacity"=> 0,
          "RectOutlineWidth"=> 0,
          "RectGradient"=> true,
          "RectGradientMode"=> "BackwardDiagonal",
          "RectGradientColor"=> "string",
          "RectGradientOpacity"=> 0,
          "RotateDegrees"=> 0,
          "Reflection"=> true,
          "ReflectionOpacity"=> 0,
          "ReflectionOffset"=> 0,
          "ReflectionHeight"=> 0,
          "Name"=> "string",
          "HTMLFieldType"=> "EditField",
          "HTMLFieldSize"=> "Small",
          "RepeatType"=> "Header"
        ]
      ],
    ];

    return json_encode($data);
  }
}
