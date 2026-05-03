class PassportModel {
  final int? id;
  final String? serialNumber;
  final BranchModel? branch;
  final List<StatusUpdateModel>? statusUpdates;

  PassportModel({
    this.id,
    this.serialNumber,
    this.branch,
    this.statusUpdates,
  });

  factory PassportModel.fromJson(Map<String, dynamic> json) {
    return PassportModel(
      id: json['id'] as int?,
      serialNumber: json['serial_number'] as String?,
      branch: json['branch'] != null ? BranchModel.fromJson(json['branch']) : null,
      statusUpdates: (json['status_updates'] ?? json['statusUpdates']) != null
          ? ((json['status_updates'] ?? json['statusUpdates']) as List)
              .map((i) => StatusUpdateModel.fromJson(i))
              .toList()
          : null,
    );
  }
}

class BranchModel {
  final int? id;
  final String? name;

  BranchModel({
    this.id,
    this.name,
  });

  factory BranchModel.fromJson(Map<String, dynamic> json) {
    return BranchModel(
      id: json['id'] as int?,
      name: json['name'] as String?,
    );
  }
}

class StatusUpdateModel {
  final int? id;
  final String? status;
  final String? createdAt;

  StatusUpdateModel({
    this.id,
    this.status,
    this.createdAt,
  });

  factory StatusUpdateModel.fromJson(Map<String, dynamic> json) {
    return StatusUpdateModel(
      id: json['id'] as int?,
      status: json['status'] as String?,
      createdAt: json['created_at'] as String?,
    );
  }
}
